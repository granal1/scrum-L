<?php

namespace App\Http\Controllers\ArchiveDocuments;

use App\Http\Controllers\Controller;
use App\Http\Filters\ArchiveDocuments\ArchiveDocumentFilter;
use App\Http\Requests\ArchiveDocuments\ArchiveDocumentFilterRequest;
use App\Http\Requests\ArchiveDocuments\UpdateArchiveDocumentFormRequest;

use App\Models\ArchiveDocuments\ArchiveDocument;

use App\Models\User;
use App\Services\ArchiveDocuments\ArchiveDocumentService;
use App\Services\Documents\DocumentYearService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

use DateTime;

class ArchiveDocumentController extends Controller
{
    public $archive_list = [];

    public function __construct()
    {
        $this->middleware(['auth']);
        $this->archiveService = new ArchiveDocumentService();
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

        $this->authorize('viewAny', ArchiveDocument::class); 
        //TODO Уточнить авторизацию для архива и для входящих документов

        $data = $request->validated();

        if(isset($data['year']))
        {
            if ($data['year'] != Session::get('year') || Session::missing('year')){
                Session::put('year', $data['year']);

                if($data['year'] > $this->archiveService->getLastArchiveYear()){               
                    return redirect()->route('documents.index', ['year'=> Session::get('year')]);
                }
            }
        }
        elseif(Session::missing('year'))
        {
            Session::put('year', $this->archiveService->getLastArchiveYear());
        }

        if(empty($this->archiveService->getYearsList()))
        {
            return view('archive_documents.index', [
                'archive_documents' => null,
                'old_filters' => null,
                'archive_years' => null,
                'year' => null,
            ]);
        }

        $documents = null;

        if (!empty($data['content'])) {
            $data['content'] = no_inject($data['content']);
            $documents = ArchiveDocument::searchByContent(Session::get('year'), $data['content']);
        }
        elseif (!empty($data['from_date']))
        {
            Session::put('from_date', substr($data['from_date'], 4));
            Session::put('to_date', substr($data['to_date'], 4));

            $start_date = Session::get('year') . Session::get('from_date');
            $finish_date = Session::get('year') . Session::get('to_date');
            $documents = ArchiveDocument::getAllByYear(Session::get('year'), $start_date, $finish_date);
        }
        elseif (Session::has('from_date'))
        {
            $start_date = Session::get('year') . Session::get('from_date');
            $finish_date = Session::get('year') . Session::get('to_date');
            $documents = ArchiveDocument::getAllByYear(Session::get('year'), $start_date, $finish_date);
        } 
        else
        {
            $start_date = Session::get('year') . '-01-01';
            $finish_date = Session::get('year') . '-12-31';
            $documents = ArchiveDocument::getAllByYear(Session::get('year'), $start_date, $finish_date);
        }

        $documents = $this->paginate($documents, config('front.archive_files.pagination'));

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

        return view('archive_documents.index', [
            'archive_documents' => $documents,
            'old_filters' => $data,
            'archive_years' => $years,
        ]);
    }


    /**
     * @param ArchiveDocument $document
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($document_id)
    {
        $this->authorize('view', ArchiveDocument::class);

        $document = null;
        $document = ArchiveDocument::getOneByIdAndYear($document_id, Session::get('year'));

        $utcTime = new DateTime($document->created_at);
        $document->created_at = $utcTime->setTimezone(timezone_open(session('localtimezone')))->format('Y-m-d H:i'); // перевод в локальный часовой пояс

        if (isset($document->tasks[0]->deadline_at)) {
            $utcTime = new DateTime($document->tasks[0]->deadline_at);
            $document->tasks[0]->deadline_at = $utcTime->setTimezone(timezone_open(session('localtimezone')))->format('Y-m-d H:i'); // перевод в локальный часовой пояс
        }

        return view('archive_documents.show', [
            'archive_document' => $document,
        ]);
    }

    /**
     * @param ArchiveDocument $document
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($document_id)
    {
        $this->authorize('update', ArchiveDocument::class);

        $document = new ArchiveDocument();
        $document = $document->getOneByIdAndYear($document_id, Session::get('year'));
        $document = json_decode(json_encode($document),true);

        return view('archive_documents.edit', [
            'archive_document' => $document,
            'users' => User::all(),
        ]);
    }

    /**
     * @param UpdateArchiveDocumentFormRequest $request
     * @param ArchiveDocument $document
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateArchiveDocumentFormRequest $request, $document_id)
    {
        $this->authorize('update', ArchiveDocument::class);

        if ($request->isMethod('patch')) {

            $data = $request->validated();

            try {

                DB::beginTransaction();

                $document = new ArchiveDocument();
                $document->updateByIdAndYear($document_id, Session::get('year'), $data);

                DB::commit();

                return redirect()->route('archive_documents.edit', $document_id)->with('success', 'Изменения сохранены.');

            } catch (\Exception $e) {

                DB::rollBack();
                Log::error($e);
            }

        }

        return redirect()->route('archive_documents.edit', $document_id)->with('error', 'Изменения не сохранились, ошибка.');
    }

    /**
     * @param ArchiveDocument $document
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($document_id)
    {
        $this->authorize('delete', ArchiveDocument::class);

        try {

            DB::beginTransaction();

            $document = new ArchiveDocument();
            $document->deleteByIdAndYear($document_id, Session::get('year'));

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
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

    private function getLastArchiveYear(): string
    {
        $years = $this->getArchiveList();
        $years = array_reverse($years);
        return substr(array_pop($years), -4);
    }

    public function paginate($items, $perPage = 2, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        $paginator = new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
        return $paginator->setPath(Paginator::resolveCurrentPath());
    }
}
