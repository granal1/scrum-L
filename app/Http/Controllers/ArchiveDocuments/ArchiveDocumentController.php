<?php

namespace App\Http\Controllers\ArchiveDocuments;

use App\Http\Controllers\Controller;
use App\Http\Filters\ArchiveDocuments\ArchiveDocumentFilter;
use App\Http\Requests\ArchiveDocuments\ArchiveDocumentFilterRequest;
use App\Http\Requests\ArchiveDocuments\StoreArchiveDocumentFormRequest;
use App\Http\Requests\ArchiveDocuments\UpdateArchiveDocumentFormRequest;

use App\Jobs\ProcessArchiveDocumentParsing;

use App\Models\ArchiveDocuments\ArchiveDocument;
use App\Services\Documents\UploadArchiveService;
use App\Services\Documents\UploadService;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

use DateTime;

class ArchiveDocumentController extends Controller
{
    public $archive_list = [];
    public $archive_year = '';

    public function __construct()
    {
        $this->middleware(['auth']);
        $this->archive_list = $this->getArchiveList();
        $this->archive_year = $this->getLastArchiveTableYear();
       // $this->authorizeResource(ArchiveDocument::class, 'archiveDocument');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(ArchiveDocumentFilterRequest $request)
    {
        Log::info(get_class($this) . ', method: ' . __FUNCTION__,
            [
                'user' => Auth::user()->name,
                'request' => $request->all(),
            ]);

        if(empty($this->archive_list))
        {
            return view('archive_documents.index', [
                'archive_documents' => null,
                'old_filters' => null,
                'archive_years' => null,
            ]);
        }

        $data = $request->validated();

        $tableName = null;

        if(isset($data['year']))
        {
            $tableName = $data['year'];
        } else {
            $tableName = $this->getLastArchiveTable();
        }

        $documents = DB::select('select * from ' . $tableName);
        $documents = $this->paginate($documents);


//        //$this->authorize('viewAny', ArchiveDocument::class);
//        $data = $request->validated();
//
//        if (isset($data['content'])) {
//            $data['content'] = no_inject($data['content']);
//        }
//        $filter = app()->make(ArchiveDocumentFilter::class, ['queryParams' => array_filter($data)]);
//
//        $documents = null;
//
//        if (!empty($data['content'])) {
//            $documents = ArchiveDocument::filter($filter)
//                ->paginate(config('front.documents.pagination'));
//        } else {
//            $documents = ArchiveDocument::orderBy('created_at', 'desc')
//                ->paginate(config('front.documents.pagination'));
//        }

        return view('archive_documents.index', [
            'archive_documents' => $documents,
            'old_filters' => $data,
            'archive_years' => $this->archive_list,
        ]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {

        //$this->authorize('create', ArchiveDocument::class);

        $last_document = ArchiveDocument::orderBy('created_at', 'desc')->first();

        return view('archive_documents.create', [
            'users' => User::all(),
            'last_document_number' => $last_document->incoming_number ?? 'отсутствует'
        ]);
    }

// test changes on git

    /**
     * @param StoreArchiveDocumentFormRequest $request
     * @param UploadService $uploadService
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreArchiveDocumentFormRequest $request, UploadService $uploadService, UploadArchiveService $uploadArchiveService)
    {
        //$this->authorize('create', Document::class);

        if ($request->isMethod('post')) {

            $data = $request->validated();

            try {

                DB::beginTransaction();

                $document = new ArchiveDocument();

                if ($request->hasFile('file')) {

                    $document->short_description = isset($data['short_description']) ? $data['short_description'] : $request->file('file')->getClientOriginalName();

                    $now = date_create("now", timezone_open(session('localtimezone')));
                    $document->path = $uploadService->uploadMedia($request->file('file'), $now);

                    if ($request->hasFile('archive_file')) {
                        $document->archive_path = $uploadArchiveService->uploadMedia($request->file('archive_file'), $now);
                    }

                    $document->incoming_at = $data['incoming_at'];
                    $document->incoming_number = $data['incoming_number'];
                    $document->incoming_author = $data['incoming_author'];
                    $document->number = $data['number'];
                    $document->date = $data['date'];
                    $document->document_and_application_sheets = $data['document_and_application_sheets'];
                    $document->author_uuid = Auth::id();
                    $document->content = 'Содержимое документа обрабатывается, скоро будет готово ...';

                    $document->save();

                    DB::commit();

                    ProcessArchiveDocumentParsing::dispatch($document)
                        ->onQueue('documents');

                }

                return redirect()->route('archive_documents.index');

            } catch (\Exception $e) {

                DB::rollBack();
                Log::error($e);
            }
        }
        return redirect()->route('archive_documents.create')->with('error', 'Ошибка при загрузке документа.');
    }

    /**
     * @param ArchiveDocument $document
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($document_id)
    {
        //$this->authorize('view', ArchiveDocument::class);
        $document = DB::table('archive_files_2021')
            ->where('id', 'LIKE', '%' . $document_id . '%')
            ->first();

        $document = json_decode(json_encode($document),true);

        $utcTime = new DateTime($document['created_at']);
        $document['created_at'] = $utcTime->setTimezone(timezone_open(session('localtimezone')))->format('Y-m-d H:i'); // перевод в локальный часовой пояс

        if (isset($document->tasks[0]->deadline_at)) {
            $utcTime = new DateTime($document->tasks[0]->deadline_at);
            $document->tasks[0]->deadline_at = $utcTime->setTimezone(timezone_open(session('localtimezone')))->format('Y-m-d H:i'); // перевод в локальный часовой пояс
        }

        return view('archive_documents.show', [
            'archive_document' => $document
        ]);
    }

    /**
     * @param ArchiveDocument $document
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(ArchiveDocument $document)
    {
        //$this->authorize('update', ArchiveDocument::class);

        return view('archive_documents.edit', [
            'document' => $document,
            'users' => User::all()
        ]);
    }

    /**
     * @param UpdateArchiveDocumentFormRequest $request
     * @param ArchiveDocument $document
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateArchiveDocumentFormRequest $request, ArchiveDocument $document)
    {
        //$this->authorize('update', ArchiveDocument::class);

        if ($request->isMethod('patch')) {

            $data = $request->validated();

            try {

                DB::beginTransaction();

                $document->update([
                    'short_description' => $data['short_description'],
                    'incoming_at' => $data['incoming_at'],
                    'incoming_number' => $data['incoming_number'],
                    'incoming_author' => $data['incoming_author'],
                    'number' => $data['number'],
                    'date' => $data['date'],
                    'document_and_application_sheets' => $data['document_and_application_sheets'],
                    'file_mark' => $data['file_mark']
                ]);

                DB::commit();

                return redirect()->route('archive_documents.edit', $document)->with('success', 'Изменения сохранены.');

            } catch (\Exception $e) {

                DB::rollBack();
                Log::error($e);
            }

        }

        return redirect()->route('archive_documents.edit', $document)->with('error', 'Изменения не сохранились, ошибка.');
    }

    /**
     * @param ArchiveDocument $document
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(ArchiveDocument $document)
    {
        //$this->authorize('delete', Document::class);

        try {

            if (Storage::exists('/public/' . $document->path)) {

                Storage::delete('/public/' . $document->path);


            }

            $document->delete();

        } catch (\Exception $e) {
            Log::error($e);
        }

        return redirect()->route('archive_documents.index');
    }

    private function getArchiveList(): array
    {
        $result = [];

        foreach (DB::select('SHOW TABLES LIKE "archive_files_%"') as $item) {
            foreach ($item as $key => $value) {
                $result[substr($value, -4)] = $value;
            }
        }
        arsort($result);
        return $result;
    }

    private function getLastArchiveTableYear(): string
    {
        $years = $this->getArchiveList();
        return substr(array_pop($years), -4);
    }

    private function getLastArchiveTable(): string
    {
        $years = $this->getArchiveList();
        return array_shift($years);
    }

    public function paginate($items, $perPage = 2, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        $paginator = new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
        return $paginator->setPath(Paginator::resolveCurrentPath());
    }
}
