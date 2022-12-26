<?php

namespace App\Http\Controllers\Documents;

use App\Http\Controllers\Controller;
use App\Http\Filters\Documents\DocumentFilter;
use App\Http\Requests\Documents\DocumentFilterRequest;
use App\Http\Requests\Documents\StoreDocumentFormRequest;
use App\Http\Requests\Documents\UpdateDocumentFormRequest;
use App\Models\Documents\Document;
use App\Services\Documents\UploadService;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Symfony\Polyfill\Uuid\Uuid;


class DocumentController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(DocumentFilterRequest $request)
    {

        $data = $request->validated();

        $filter = app()->make(DocumentFilter::class, ['queryParams' => array_filter($data)]);

        $documents = Document::filter($filter)
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
        if (! Gate::allows('create-document')) {
            abort(403);
        }

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
        if($request->isMethod('post')) {

            $data = $request->validated();

            try {

                DB::beginTransaction();

                $document = new Document();

                if ($request->hasFile('file')) {

                    $document->name = isset($data['name']) ? $data['name'] : $request->file('file')->getClientOriginalName();

                    $document->path = $uploadService->uploadMedia($request->file('file'));

                    $document->save();
                }

                DB::commit();

                return redirect()->route('documents.show', $document)->with('success', 'Документ загружен.');

            } catch (\Exception $e) {

                DB::rollBack();
                dd($e); // TODO сделать вывод ошибки в журнал, что сайт не крашился

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
        if($request->isMethod('patch')) {

            $data = $request->validated();

            try {

                DB::beginTransaction();

                $document->update([
                    'name' => $data['name']
                ]);

                DB::commit();

                return redirect()->route('documents.edit', $document)->with('success','Изменения сохранены.');

            } catch (\Exception $e) {

                DB::rollBack();
                dd($e); // TODO сделать вывод ошибки в журнал, что сайт не крашился

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
        if(Storage::exists('/public/' . $document->path)){

            Storage::delete('/public/' . $document->path);

        }else{
            // TODO сделать вывод в лог, чтобы сайт не крашился
            dd('File does not exist.');
        }

        $document->delete();

        return redirect()->route('documents.index');
    }
}
