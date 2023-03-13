<?php

namespace App\Http\Controllers\ArchiveOutgoingDocuments;

use App\Http\Controllers\Controller;
use App\Http\Filters\ArchiveOutgoingDocuments\ArchiveOutgoingDocumentFilter;
use App\Http\Requests\ArchiveOutgoingDocuments\ArchiveOutgoingDocumentFilterRequest;
use App\Http\Requests\ArchiveOutgoingDocuments\UpdateArchiveOutgoingDocumentFormRequest;

use App\Models\ArchiveOutgoingDocuments\ArchiveOutgoingDocument;

use App\Models\User;
use App\Services\ArchiveOutgoingDocuments\ArchiveOutgoingDocumentService;
use App\Services\OutgoingFiles\OutgoingDocumentYearService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

use DateTime;

class ArchiveOutgoingDocumentController extends Controller
{
    public $archive_list = [];

    public function __construct()
    {
        $this->middleware(['auth']);
        $this->archiveService = new ArchiveOutgoingDocumentService();
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(ArchiveOutgoingDocumentFilterRequest $request)
    {
        Log::info(get_class($this) . ', method: ' . __FUNCTION__,
            [
                'user' => Auth::user()->name,
                'request' => $request->all(),
            ]);

        $this->authorize('viewAny', ArchiveOutgoingDocument::class);

        if(empty($this->archiveService->getYearsList()))
        {
            return view('archive_outgoing_documents.index', [
                'archive_outgoing_documents' => null,
                'old_filters' => null,
                'archive_years' => null,
                'year' => null,
            ]);
        }

        $data = $request->validated();

        if(isset($data['year']))
        {
            Session::put('year', $data['year']);
        } else {
            Session::put('year', $this->archiveService->getLastArchiveYear());
        }

        if(Session::get('year') > $this->archiveService->getLastArchiveYear())
        {
            return redirect()->route('outgoing_files.index', ['year' => Session::get('year')]);
        }

        $documents = new ArchiveOutgoingDocument();

        if (isset($data['content'])) {
            $data['content'] = no_inject($data['content']);
            $documents = $documents->searchByContent(Session::get('year'), $data['content']);
        } else
        {
            $documents = $documents->getAllByYear(Session::get('year'));
        }

        $documents = $this->paginate($documents, config('front.archive_outgoing_files.pagination'));

        $yearService = new OutgoingDocumentYearService();
        $years = [];

        foreach($yearService->getYearsList() as $year)
        {
            $years[] = $year;
        }

        foreach ($this->archiveService->getYearsList() as $year)
        {
            $years[] = $year;
        }

        return view('archive_outgoing_documents.index', [
            'archive_outgoing_documents' => $documents,
            'old_filters' => $data,
            'years' => $years,
        ]);
    }


    /**
     * @param ArchiveOutgoingDocument $document
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($document_id)
    {
        $this->authorize('view', ArchiveOutgoingDocument::class);

        //$document = new ArchiveOutgoingDocument();
        //$document = $document->getOneByIdAndYear($document_id, Session::get('year'));
        //$document = json_decode(json_encode($document),true);

        $document = null;
        $document = ArchiveOutgoingDocument::getOneByIdAndYear($document_id, Session::get('year'));

        //$utcTime = new DateTime($document['created_at']);
        //$document['created_at'] = $utcTime->setTimezone(timezone_open(session('localtimezone')))->format('Y-m-d H:i'); // перевод в локальный часовой пояс
        $utcTime = new DateTime($document->created_at);
        $document->created_at = $utcTime->setTimezone(timezone_open(session('localtimezone')))->format('Y-m-d H:i'); // перевод в локальный часовой пояс

        if (isset($document->tasks[0]->deadline_at)) {
            $utcTime = new DateTime($document->tasks[0]->deadline_at);
            $document->tasks[0]->deadline_at = $utcTime->setTimezone(timezone_open(session('localtimezone')))->format('Y-m-d H:i'); // перевод в локальный часовой пояс
        }

        return view('archive_outgoing_documents.show', [
            'archive_document' => $document,
        ]);
    }

    /**
     * @param ArchiveOutgoingDocument $document
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($document_id)
    {
        $this->authorize('update', ArchiveOutgoingDocument::class);

        $document = new ArchiveOutgoingDocument();
        $document = $document->getOneByIdAndYear($document_id, Session::get('year'));
        $document = json_decode(json_encode($document),true);

        return view('archive_outgoing_documents.edit', [
            'archive_document' => $document,
            'users' => User::all(),
        ]);
    }

    /**
     * @param UpdateArchiveOutgoingDocumentFormRequest $request
     * @param ArchiveOutgoingDocument $document
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateArchiveOutgoingDocumentFormRequest $request, $document_id)
    {
        $this->authorize('update', ArchiveOutgoingDocument::class);

        if ($request->isMethod('patch')) {

            $data = $request->validated();

            try {

                DB::beginTransaction();

                $document = new ArchiveOutgoingDocument();
                $document->updateByIdAndYear($document_id, Session::get('year'), $data);

                DB::commit();

                return redirect()->route('archive_outgoing_documents.edit', $document_id)->with('success', 'Изменения сохранены.');

            } catch (\Exception $e) {

                DB::rollBack();
                Log::error($e);
            }

        }

        return redirect()->route('archive_outgoing_documents.edit', $document_id)->with('error', 'Изменения не сохранились, ошибка.');
    }

    /**
     * @param ArchiveOutgoingDocument $document
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($document_id)
    {
        $this->authorize('delete', ArchiveOutgoingDocument::class);

        try {

            DB::beginTransaction();

            $document = new ArchiveOutgoingDocument();
            $document->deleteByIdAndYear($document_id, Session::get('year'));

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
        }

        return redirect()->route('archive_outgoing_documents.index');
    }

    public function paginate($items, $perPage = 2, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        $paginator = new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
        return $paginator->setPath(Paginator::resolveCurrentPath());
    }
}
