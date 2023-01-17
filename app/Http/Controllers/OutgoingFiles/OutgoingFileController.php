<?php

namespace App\Http\Controllers\OutgoingFiles;

use App\Http\Controllers\Controller;
use App\Http\Filters\OutgoingFiles\OutgoingFileFilter;
use App\Http\Requests\OutgoingFiles\OutgoingFileFilterRequest;
use App\Http\Requests\OutgoingFiles\StoreOutgoingFileFormRequest;
use App\Http\Requests\OutgoingFiles\UpdateOutgoingFileFormRequest;
use App\Models\OutgoingFiles\OutgoingFile;
use App\Models\Tasks\TaskPriority;
use App\Services\OutgoingFiles\UploadService;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Polyfill\Uuid\Uuid;


class OutgoingFileController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth']);
        $this->authorizeResource(OutgoingFile::class, 'outgoing_file');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(OutgoingFileFilterRequest $request)
    {
        Log::info(get_class($this) . ', method: ' . __FUNCTION__,
            [
                'user' => Auth::user()->name,
                'request' => $request->all(),

            ]);

        //$this->authorize('viewAny', OutgoingFile::class);

        $data = $request->validated();

        $filter = app()->make(OutgoingFileFilter::class, ['queryParams' => array_filter($data)]);

        $outgoing_files = OutgoingFile::filter($filter)
            ->orderBy('created_at', 'desc')
            ->paginate(config('front.outgoing_files.pagination'));

        return view('outgoing_files.index',[
            'output_files' => $outgoing_files,
            'old_filters' => $data,
        ]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {

        //$this->authorize('create', OutgoingFile::class);

        return view('outgoing_files.create', [
            'users' => User::all()
        ]);
    }


    /**
     * @param StoreOutgoingFileFormRequest $request
     * @param UploadService $uploadService
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreOutgoingFileFormRequest $request, UploadService $uploadService)
    {
        //$this->authorize('create', OutgoingFile::class);

        if($request->isMethod('post')) {

            $data = $request->validated();

            try {

                DB::beginTransaction();

                $outgoing_file = new OutgoingFile();

                if ($request->hasFile('file')) {

                    $outgoing_file->short_description = isset($data['short_description']) ? $data['short_description'] : $request->file('file')->getClientOriginalName();
                    $outgoing_file->path = $uploadService->uploadMedia($request->file('file'));

                    $outgoing_file->outgoing_at = $data['outgoing_at'];
                    $outgoing_file->outgoing_number = $data['outgoing_number'];
                    $outgoing_file->destination = $data['destination'];
                    $outgoing_file->number_of_source_document = $data['number_of_source_document'];
                    $outgoing_file->date_of_source_document = $data['date_of_source_document'];
                    $outgoing_file->document_and_application_sheets = $data['document_and_application_sheets'];
                    $outgoing_file->author_uuid = Auth::id();

                    $outgoing_file->save();
                }

                DB::commit();

                return redirect()->route('outgoing_files.show', $outgoing_file)->with('success', 'Документ загружен.');

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

        if($request->isMethod('patch')) {

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

                return redirect()->route('outgoing_files.edit', $outgoing_file)->with('success','Изменения сохранены.');

            } catch (\Exception $e) {

                DB::rollBack();
                Log::error($e);
            }

        }

        return redirect()->route('outgoing_files.edit', $outgoing_file)->with('error','Изменения не сохранились, ошибка.');
    }

    /**
     * @param OutgoingFile $outgoing_file
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(OutgoingFile $outgoing_file)
    {
        //$this->authorize('delete', OutgoingFile::class);

        try{

            if(Storage::exists('/public/' . $outgoing_file->path)){

                Storage::delete('/public/' . $outgoing_file->path);


            }

            $outgoing_file->delete();

        } catch (\Exception $e) {
            Log::error($e);
        }

        return redirect()->route('outgoing_files.index');
    }
}
