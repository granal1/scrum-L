<?php

namespace App\Http\Controllers\OutgoingFiles;

use App\Http\Controllers\Controller;
use App\Http\Filters\OutgoingFiles\OutgoingFileFilter;
use App\Http\Requests\OutgoingFiles\OutgoingFileFilterRequest;
use App\Http\Requests\OutgoingFiles\StoreOutgoingFileFormRequest;
use App\Http\Requests\OutgoingFiles\UpdateOutgoingFileFormRequest;
use App\Jobs\ProcessOutgoingFileParsing;
use App\Models\OutgoingFiles\OutgoingFile;
use App\Services\ArchiveOutgoingDocuments\ArchiveOutgoingDocumentService;
use App\Services\OutgoingFiles\OutgoingDocumentYearService;
use App\Services\OutgoingFiles\UploadArchiveService;
use App\Services\OutgoingFiles\UploadService;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use DateTime;


class OutgoingFileController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth']);
        $this->authorizeResource(OutgoingFile::class, 'outgoing_file');
        $this->archiveService = new ArchiveOutgoingDocumentService();

    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(OutgoingFileFilterRequest $request)
    {
        Log::info(
            get_class($this) . ', method: ' . __FUNCTION__,
            [
                'user' => Auth::user()->name,
                'request' => $request->all(),

            ]
        );

        //$this->authorize('viewAny', OutgoingFile::class);

        $data = $request->validated();

        if(isset($data['year']))
        {
            Session::put('year', $data['year']);
        } else {
            Session::put('year', date('Y'));
        }

        if (isset($data['content'])) {
            $data['content'] = no_inject($data['content']);
        }

        $filter = app()->make(OutgoingFileFilter::class, ['queryParams' => array_filter($data)]);

        $outgoing_files = null;

        if(Session::get('year') > $this->archiveService->getLastArchiveYear()) {
            if (!empty($data['content'])) {

                $outgoing_files = OutgoingFile::filter($filter)
                    ->whereYear('outgoing_at', Session::get('year'))
                    ->paginate(config('front.documents.pagination'));

            } else {

                $outgoing_files = OutgoingFile::orderBy('created_at', 'desc')
                    ->whereYear('outgoing_at', Session::get('year'))
                    ->paginate(config('front.documents.pagination'));

            }
        } else {
            return redirect()->route('archive_outgoing_documents.index', ['year'=> Session::get('year')]);
        }

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

        return view('outgoing_files.index', [
            'output_files' => $outgoing_files,
            'old_filters' => $data,
            'years' => $years,
        ]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {

        //$this->authorize('create', OutgoingFile::class);

        $last_document = OutgoingFile::orderBy('created_at', 'desc')->first();

        return view('outgoing_files.create', [
            'users' => User::all(),
            'last_document_number' => $last_document->outgoing_number ?? 'отсутствует'
        ]);
    }


    /**
     * @param StoreOutgoingFileFormRequest $request
     * @param UploadService $uploadService
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreOutgoingFileFormRequest $request, UploadService $uploadService, UploadArchiveService $uploadArchiveService)
    {
        //$this->authorize('create', OutgoingFile::class);

        if ($request->isMethod('post')) {

            $data = $request->validated();

            try {

                DB::beginTransaction();

                $data['executor_uuid'] = User::where('name', 'like', $data['executor_name'])->pluck('id')->first();

                $outgoing_file = new OutgoingFile();

                if ($request->hasFile('file')) {

                    $outgoing_file->short_description = isset($data['short_description']) ? $data['short_description'] : $request->file('file')->getClientOriginalName();

                    $now = date_create("now", timezone_open(session('localtimezone')));
                    $outgoing_file->path = $uploadService->uploadMedia($request->file('file'), $now);
                    if ($request->hasFile('archive_file')) {
                        $outgoing_file->archive_path = $uploadArchiveService->uploadMedia($request->file('archive_file'), $now);
                    }

                    $outgoing_file->outgoing_at = $data['outgoing_at'];
                    $outgoing_file->outgoing_number = $data['outgoing_number'];
                    $outgoing_file->destination = $data['destination'];
                    $outgoing_file->number_of_source_document = $data['number_of_source_document'];
                    $outgoing_file->date_of_source_document = $data['date_of_source_document'];
                    $outgoing_file->document_and_application_sheets = $data['document_and_application_sheets'];
                    $outgoing_file->author_uuid = Auth::id();
                    $outgoing_file->executor_uuid = $data['executor_uuid'];
                    $outgoing_file->content = 'Содержимое документа обрабатывается, скоро будет готово ...';

                    $outgoing_file->save();

                    DB::commit();

                    ProcessOutgoingFileParsing::dispatch($outgoing_file)
                        ->onQueue('outgoing_files');
                }

                return redirect()->route('outgoing_files.index');

            } catch (\Exception $e) {

                DB::rollBack();
                Log::error($e);
            }
        }
        return redirect()->route('outgoing_files.create')->with('error', 'Ошибка при загрузке документа.');
    }

    /**
     * @param OutgoingFile $outgoing_file
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(OutgoingFile $outgoing_file)
    {
        //$this->authorize('view', OutgoingFile::class);

        $utcTime = new DateTime($outgoing_file['created_at']);
        $outgoing_file['created_at'] = $utcTime->setTimezone(timezone_open(session('localtimezone')))->format('Y-m-d H:i'); // перевод влокальный часовой пояс

        return view('outgoing_files.show', [
            'output_file' => $outgoing_file
        ]);
    }

    /**
     * @param OutgoingFile $outgoing_file
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(OutgoingFile $outgoing_file)
    {
        //$this->authorize('update', OutgoingFile::class);

        return view('outgoing_files.edit', [
            'output_file' => $outgoing_file,
            'users' => User::all()
        ]);
    }

    /**
     * @param UpdateOutgoingFileFormRequest $request
     * @param OutgoingFile $outgoing_file
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateOutgoingFileFormRequest $request, OutgoingFile $outgoing_file)
    {
        //$this->authorize('update', OutgoingFile::class);

        if ($request->isMethod('patch')) {

            $data = $request->validated();

            try {

                DB::beginTransaction();

                $outgoing_file->update([
                    'short_description' => $data['short_description'],
                    'outgoing_at' => $data['outgoing_at'],
                    'outgoing_number' => $data['outgoing_number'],
                    'destination' => $data['destination'],
                    'number_of_source_document' => $data['number_of_source_document'],
                    'date_of_source_document' => $data['date_of_source_document'],
                    'document_and_application_sheets' => $data['document_and_application_sheets'],
                    'file_mark' => $data['file_mark']
                ]);

                DB::commit();

                return redirect()->route('outgoing_files.edit', $outgoing_file)->with('success', 'Изменения сохранены.');
            } catch (\Exception $e) {

                DB::rollBack();
                Log::error($e);
            }
        }

        return redirect()->route('outgoing_files.edit', $outgoing_file)->with('error', 'Изменения не сохранились, ошибка.');
    }

    /**
     * @param OutgoingFile $outgoing_file
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(OutgoingFile $outgoing_file)
    {
        //$this->authorize('delete', OutgoingFile::class);

        try {

            if (Storage::exists('/public/' . $outgoing_file->path)) {

                Storage::delete('/public/' . $outgoing_file->path);
            }

            $outgoing_file->delete();
        } catch (\Exception $e) {
            Log::error($e);
        }

        return redirect()->route('outgoing_files.index');
    }
}
