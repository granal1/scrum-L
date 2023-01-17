<?php

namespace App\Http\Controllers\Documents;

use App\Http\Controllers\Controller;
use App\Http\Filters\Documents\DocumentFilter;
use App\Http\Requests\Documents\DocumentFilterRequest;
use App\Http\Requests\Documents\StoreDocumentFormRequest;
use App\Http\Requests\Documents\UpdateDocumentFormRequest;
use App\Models\Documents\Document;
use App\Models\Tasks\TaskPriority;
use App\Services\Documents\UploadService;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Polyfill\Uuid\Uuid;


class DocumentController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth']);
        $this->authorizeResource(Document::class, 'document');
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

        $filter = app()->make(DocumentFilter::class, ['queryParams' => array_filter($data)]);

        $documents = Document::filter($filter)
            ->orderBy('created_at', 'desc')
            ->paginate(config('front.documents.pagination'));

        return view('documents.index',[
            'documents' => $documents,
            'old_filters' => $data,
        ]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {

        //$this->authorize('create', Document::class);

        return view('documents.create', [
            'users' => User::all()
        ]);
    }


    /**
     * @param StoreDocumentFormRequest $request
     * @param UploadService $uploadService
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreDocumentFormRequest $request, UploadService $uploadService)
    {
        //$this->authorize('create', Document::class);

        if($request->isMethod('post')) {

            $data = $request->validated();

            try {

                DB::beginTransaction();

                $document = new Document();

                if ($request->hasFile('file')) {

                    $document->short_description = isset($data['short_description']) ? $data['short_description'] : $request->file('file')->getClientOriginalName();
                    $document->path = $uploadService->uploadMedia($request->file('file'));

                    $document->incoming_at = $data['incoming_at'];
                    $document->incoming_number = $data['incoming_number'];
                    $document->incoming_author = $data['incoming_author'];
                    $document->number = $data['number'];
                    $document->date = $data['date'];
                    $document->document_and_application_sheets = $data['document_and_application_sheets'];
                    $document->author_uuid = Auth::id();

                    $document->save();
                }

                DB::commit();

                return redirect()->route('documents.show', $document)->with('success', 'Документ загружен.');

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

        if($request->isMethod('patch')) {

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

                return redirect()->route('documents.edit', $document)->with('success','Изменения сохранены.');

            } catch (\Exception $e) {

                DB::rollBack();
                Log::error($e);
            }

        }

        return redirect()->route('documents.edit', $document)->with('error','Изменения не сохранились, ошибка.');
    }

    /**
     * @param Document $document
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Document $document)
    {
        //$this->authorize('delete', Document::class);

        try{

            if(Storage::exists('/public/' . $document->path)){

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
