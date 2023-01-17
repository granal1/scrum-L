<?php

namespace App\Http\Controllers\OutputFiles;

use App\Http\Controllers\Controller;
use App\Http\Filters\OutputFiles\OutputFileFilter;
use App\Http\Requests\OutputFiles\OutputFileFilterRequest;
use App\Http\Requests\OutputFiles\StoreOutputFileFormRequest;
use App\Http\Requests\OutputFiles\UpdateOutputFileFormRequest;
use App\Models\OutputFiles\OutputFile;
use App\Models\Tasks\TaskPriority;
use App\Services\OutputFiles\UploadService;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Polyfill\Uuid\Uuid;


class OutputFileController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth']);
        $this->authorizeResource(OutputFile::class, 'output_file');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(OutputFileFilterRequest $request)
    {
        Log::info(get_class($this) . ', method: ' . __FUNCTION__,
            [
                'user' => Auth::user()->name,
                'request' => $request->all(),

            ]);

        //$this->authorize('viewAny', OutputFile::class);

        $data = $request->validated();

        $filter = app()->make(OutputFileFilter::class, ['queryParams' => array_filter($data)]);

        $output_files = OutputFile::filter($filter)
            ->orderBy('created_at', 'desc')
            ->paginate(config('front.OutputFiles.pagination'));

        return view('output_files.index',[
            'output_files' => $output_files,
            'old_filters' => $data,
        ]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {

        //$this->authorize('create', OutputFile::class);

        return view('output_files.create', [
            'users' => User::all()
        ]);
    }


    /**
     * @param StoreOutputFileFormRequest $request
     * @param UploadService $uploadService
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreOutputFileFormRequest $request, UploadService $uploadService)
    {
        //$this->authorize('create', OutputFile::class);

        if($request->isMethod('post')) {

            $data = $request->validated();

            try {

                DB::beginTransaction();

                $output_file = new OutputFile();

                if ($request->hasFile('file')) {

                    $output_file->short_description = isset($data['short_description']) ? $data['short_description'] : $request->file('file')->getClientOriginalName();
                    $output_file->path = $uploadService->uploadMedia($request->file('file'));

                    $output_file->incoming_at = $data['incoming_at'];
                    $output_file->incoming_number = $data['incoming_number'];
                    $output_file->incoming_author = $data['incoming_author'];
                    $output_file->number = $data['number'];
                    $output_file->date = $data['date'];
                    $output_file->document_and_application_sheets = $data['document_and_application_sheets'];
                    $output_file->author_uuid = Auth::id();

                    $output_file->save();
                }

                DB::commit();

                return redirect()->route('output_files.show', $output_file)->with('success', 'Документ загружен.');

            } catch (\Exception $e) {

                DB::rollBack();
                Log::error($e);
            }
        }
            return redirect()->route('output_files.create')->with('error', 'Ошибка при загрузке документа.');
    }

    /**
     * @param OutputFile $output_file
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(OutputFile $output_file)
    {
        //$this->authorize('view', OutputFile::class);

        return view('output_files.show', [
            'output_file' => $output_file
        ]);
    }

    /**
     * @param OutputFile $output_file
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(OutputFile $output_file)
    {
        //$this->authorize('update', OutputFile::class);

        return view('output_files.edit', [
            'output_file' => $output_file,
            'users' => User::all()
        ]);
    }

    /**
     * @param UpdateOutputFileFormRequest $request
     * @param OutputFile $output_file
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateOutputFileFormRequest $request, OutputFile $output_file)
    {
        //$this->authorize('update', OutputFile::class);

        if($request->isMethod('patch')) {

            $data = $request->validated();

            try {

                DB::beginTransaction();

                $output_file->update([
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

                return redirect()->route('output_files.edit', $output_file)->with('success','Изменения сохранены.');

            } catch (\Exception $e) {

                DB::rollBack();
                Log::error($e);
            }

        }

        return redirect()->route('output_files.edit', $output_file)->with('error','Изменения не сохранились, ошибка.');
    }

    /**
     * @param OutputFile $output_file
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(OutputFile $output_file)
    {
        //$this->authorize('delete', OutputFile::class);

        try{

            if(Storage::exists('/public/' . $output_file->path)){

                Storage::delete('/public/' . $output_file->path);


            }

            $output_file->delete();

        } catch (\Exception $e) {
            Log::error($e);
        }

        return redirect()->route('output_files.index');
    }

    public function create_task(OutputFile $output_file)
    {

        $this->authorize('create_task', OutputFile::class);

        return view('output_files.create-task', [
            'output_file' => $output_file,
            'users' => User::where('superior_uuid', 'like', Auth::id())->orWhere('id', 'like', Auth::id())->get(),
            'priorities' => TaskPriority::all(),
        ]);
    }
}
