<?php

namespace App\Http\Controllers\Archives;

use App\Http\Controllers\Controller;
use App\Http\Requests\Archives\ArchiveDocumentFilterRequest;
use App\Http\Filters\ArchiveDocuments\ArchiveDocumentFilter;
use App\Models\Archives\ArchiveDocument;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ArchiveDocumentController extends Controller
{

    public array $archive_list;

    public function __construct()
    {
        $this->archive_list = $this->getArchiveList();
        $this->middleware(['auth']);
        $this->authorizeResource(ArchiveDocument::class, 'archiveDocument');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ArchiveDocumentFilterRequest $request)
    {
        Log::info(
            get_class($this) . ', method: ' . __FUNCTION__,
            [
                'user' => Auth::user()->name,
                'request' => $request->all(),

            ]
        );

        if (isset($request['archive'])) {
            $archive = $request['archive'];
        } else {
            $archive = $this->archive_list[array_key_first($this->archive_list)];
        }

        $documents = new ArchiveDocument($archive);

        $data = $request->validated();
        if (isset($data['content'])) {
            $data['content'] = no_inject($data['content']);
        }
        
        $filter = app()->make(ArchiveDocumentFilter::class, ['queryParams' => array_filter($data)]);

        if (!empty($data['content'])) {
            $documents = $documents->filter($filter)
                ->paginate(config('front.documents.pagination'));
        } else {
            $documents = $documents->orderBy('created_at', 'desc')
                ->paginate(config('front.documents.pagination'));
        }

        return view('archives.index', [
            'documents' => $documents,
            'old_filters' => $data,
            'archive_list' => $this->archive_list,
            'archive' => $archive,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ArchiveDocumentFilterRequest $request)
    {
        dd($request);
        $document = new ArchiveDocument($this->archive_list[array_key_first($this->archive_list)]);
        $utcTime = new DateTime($document['created_at']);
        $document['created_at'] = $utcTime->setTimezone(timezone_open(session('localtimezone')))->format('Y-m-d H:i'); // перевод в локальный часовой пояс

        if (isset($document->tasks[0]->deadline_at)) {
            $utcTime = new DateTime($document->tasks[0]->deadline_at);
            $document->tasks[0]->deadline_at = $utcTime->setTimezone(timezone_open(session('localtimezone')))->format('Y-m-d H:i'); // перевод в локальный часовой пояс
        }

        return view('archive_documents.show', [
            'document' => $document
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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
}
