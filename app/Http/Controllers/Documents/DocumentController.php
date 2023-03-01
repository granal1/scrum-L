<?php

namespace App\Http\Controllers\Documents;

use App\Http\Controllers\Controller;
use App\Http\Filters\AbstractFilter;
use App\Http\Filters\Documents\DocumentFilter;
use App\Http\Requests\Documents\DocumentFilterRequest;
use App\Http\Requests\Documents\StoreDocumentFormRequest;
use App\Http\Requests\Documents\UpdateDocumentFormRequest;

use App\Jobs\ProcessDocumentParsing;

use App\Models\ArchiveDocuments\ArchiveDocument;
use App\Models\Documents\Document;
use App\Models\Tasks\TaskPriority;
use App\Services\ArchiveDocuments\ArchiveDocumentService;
use App\Services\Documents\DocumentYearService;
use App\Services\Documents\UploadArchiveService;
use App\Services\Documents\UploadService;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;
use Symfony\Polyfill\Uuid\Uuid;
use DateTime;


class DocumentController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth']);
        $this->authorizeResource(Document::class, 'document');
        $this->archiveService = new ArchiveDocumentService();
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(DocumentFilterRequest $request)
    {

        Log::info(get_class($this) . ', method: ' . __FUNCTION__,
            [
                'user' => Auth::user()->name,
                'request' => $request->all(),

            ]);

        //$this->authorize('viewAny', Document::class);
        $data = $request->validated();

        Session::put('year', date('Y'));

        if(isset($data['year']))
        {
            Session::put('year', $data['year']);
        }


        if (isset($data['content'])) {
            $data['content'] = no_inject($data['content']);
        }

        $filter = app()->make(DocumentFilter::class, ['queryParams' => array_filter($data)]);

        $documents = null;

        if(Session::get('year') > $this->archiveService->getLastArchiveYear())
        {
            if (!empty($data['content'])) {

                $documents = Document::filter($filter)
                    ->with('tasks')
                    ->whereYear('incoming_at', Session::get('year'))
                    ->paginate(config('front.documents.pagination'));

            } elseif (!empty($data['from_day']))
            {

                $start_date = Session::get('year') . '-' . $data['from_month'] . '-' . $data['from_day'];
                $finish_date = Session::get('year') . '-' . $data['to_month'] . '-' . $data['to_day'];

                Session::put('from_day', $data['from_day']);
                Session::put('from_month',  $data['from_month']);
                Session::put('to_day', $data['to_day']);
                Session::put('to_month',  $data['to_month']);

                $documents = Document::whereBetween('incoming_at', [$start_date, $finish_date])
                    ->with('tasks')
                    ->orderBy('incoming_at', 'desc')
                    ->paginate(config('front.documents.pagination'));

            }
                elseif (Session::has('from_day'))
            {

                $start_date = Session::get('year') . '-' . Session::get('from_month') . '-' . Session::get('from_day');
                $finish_date = Session::get('year') . '-' . Session::get('to_month') . '-' . Session::get('to_day');

                $documents = Document::whereBetween('incoming_at', [$start_date, $finish_date])
                    ->with('tasks')
                    ->orderBy('incoming_at', 'desc')
                    ->paginate(config('front.documents.pagination'));

            }  else {

                $documents = Document::orderBy('incoming_at', 'desc')
                    ->with('tasks')
                    ->whereYear('incoming_at', Session::get('year'))
                    ->paginate(config('front.documents.pagination'));

            }

        } else {

            return redirect()->route('archive_documents.index', ['year'=> Session::get('year')]);

        }

        $yearService = new DocumentYearService();
        $years = [];

        foreach($yearService->getYearsList() as $year)
        {
            $years[] = $year;
        }

        foreach ($this->archiveService->getYearsList() as $year)
        {
            $years[] = $year;
        }

        return view('documents.index', [
            'documents' => $documents,
            'old_filters' => $data,
            'years' => $years,
        ]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {

        //$this->authorize('create', Document::class);

        $last_document = Document::orderBy('created_at', 'desc')->first();

        return view('documents.create', [
            'users' => User::all(),
            'last_document_number' => $last_document->incoming_number ?? 'отсутствует'
        ]);
    }

// test changes on git

    /**
     * @param StoreDocumentFormRequest $request
     * @param UploadService $uploadService
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreDocumentFormRequest $request, UploadService $uploadService, UploadArchiveService $uploadArchiveService)
    {
        //$this->authorize('create', Document::class);

        if ($request->isMethod('post')) {

            $data = $request->validated();

            try {

                DB::beginTransaction();

                $document = new Document();

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

                    ProcessDocumentParsing::dispatch($document)
                        ->onQueue('documents');

                }

                return redirect()->route('documents.index');

            } catch (\Exception $e) {

                DB::rollBack();
                Log::error($e);
            }
        }
        return redirect()->route('documents.create')->with('error', 'Ошибка при загрузке документа.');
    }

    /**
     * @param Document $document
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Document $document)
    {
        //$this->authorize('view', Document::class);

        $utcTime = new DateTime($document['created_at']);
        $document['created_at'] = $utcTime->setTimezone(timezone_open(session('localtimezone')))->format('Y-m-d H:i'); // перевод в локальный часовой пояс

        if (isset($document->tasks[0]->deadline_at)) {
            $utcTime = new DateTime($document->tasks[0]->deadline_at);
            $document->tasks[0]->deadline_at = $utcTime->setTimezone(timezone_open(session('localtimezone')))->format('Y-m-d H:i'); // перевод в локальный часовой пояс
        }

        return view('documents.show', [
            'document' => $document
        ]);
    }

    /**
     * @param Document $document
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Document $document)
    {
        //$this->authorize('update', Document::class);

        return view('documents.edit', [
            'document' => $document,
            'users' => User::all()
        ]);
    }

    /**
     * @param UpdateDocumentFormRequest $request
     * @param Document $document
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateDocumentFormRequest $request, Document $document)
    {
        //$this->authorize('update', Document::class);

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

                return redirect()->route('documents.edit', $document)->with('success', 'Изменения сохранены.');

            } catch (\Exception $e) {

                DB::rollBack();
                Log::error($e);
            }

        }

        return redirect()->route('documents.edit', $document)->with('error', 'Изменения не сохранились, ошибка.');
    }

    /**
     * @param Document $document
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Document $document)
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

        return redirect()->route('documents.index');
    }

    public function create_task(Document $document)
    {

        $this->authorize('create_task', Document::class);

        return view('documents.create-task', [
            'document' => $document,
            'users' => User::where('superior_uuid', 'like', Auth::id())->orWhere('id', 'like', Auth::id())->get(),
            'priorities' => TaskPriority::all(),
        ]);
    }
}
