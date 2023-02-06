<?php

namespace App\Http\Controllers\Archives;

use App\Http\Controllers\Controller;
use App\Http\Filters\ArchiveOutgoingFiles\ArchiveOutgoingFileFilter;
use App\Http\Requests\ArchiveOutgoingFiles\ArchiveOutgoingFileFilterRequest;
use App\Models\ArchivesOutgoingFiles\ArchiveOutgoingFile;
use App\Models\User;
use App\Models\UserStatuses\UserStatus;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ArchiveOutgoingFileController extends Controller
{

    public array $archive_list;

    public function __construct()
    {
        $this->archive_list = $this->getArchiveList();
        $this->middleware(['auth']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ArchiveOutgoingFileFilterRequest $request)
    {
        Log::info(
            get_class($this) . ', method: ' . __FUNCTION__,
            [
                'user' => Auth::user()->name,
                'request' => $request->all(),

            ]
        );

        $this->authorize('viewAny', ArchiveOutgoingFile::class);

        if (isset($request['archive'])) {
            $archive = $request['archive'];
            session(['archive_name' => $archive]);
        } else {
            $archive = $this->archive_list[array_key_first($this->archive_list)];
            session(['archive_name' => $archive]);
        }

        $document = new ArchiveOutgoingFile($archive);

        $data = $request->validated();
        if (isset($data['content'])) {
            $data['content'] = no_inject($data['content']);
        }

        $filter = app()->make(ArchiveOutgoingFileFilter::class, ['queryParams' => array_filter($data)]);

        $outgoing_files = $filter
            ?
            $document->filter($filter)
            ->paginate(config('front.outgoing_files.pagination'))
            :
            $document->orderBy('created_at', 'desc')
            ->paginate(config('front.outgoing_files.pagination'));

        if(!empty($data['content']))
        {
            $outgoing_files = $document->filter($filter)
                ->paginate(config('front.outgoing_files.pagination'));
        } else {
            $outgoing_files = $document->orderBy('created_at', 'desc')
                ->paginate(config('front.outgoing_files.pagination'));
        }

        return view('archive_outgoing_files.index', [
            'output_files' => $outgoing_files,
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
    public function show($id)
    {
        $this->authorize('view', ArchiveOutgoingFile::class);

        $archiveDocument = new ArchiveOutgoingFile(session('archive_name'));

        $outgoing_file = $archiveDocument->find($id);

        $utcTime = new DateTime($outgoing_file['created_at']);
        $outgoing_file['created_at'] = $utcTime->setTimezone(timezone_open(session('localtimezone')))->format('Y-m-d H:i'); // перевод влокальный часовой пояс

        $user = User::find($outgoing_file->executor_uuid);
        $user_status = UserStatus::find($user->user_status_uuid);
        $curren_status = ($user_status->id === '34ac2092-2a1e-4920-9639-4e0d774aef6b') ? "" : ' (' . $user_status->name . ')' ;
        $outgoing_file->executor_uuid = $user->name . $curren_status;

        return view('archive_outgoing_files.show', [
            'output_file' => $outgoing_file
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

        foreach (DB::select('SHOW TABLES LIKE "archive_outgoing_files_%"') as $item) {
            foreach ($item as $key => $value) {
                $result[substr($value, -4)] = $value;
            }
        }
        arsort($result);
        return $result;
    }
}
