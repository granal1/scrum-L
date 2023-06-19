<?php

namespace App\Http\Controllers\SiteLogs;

use App\Http\Controllers\Controller;
use App\Services\SiteLogs\SiteLogService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class SiteLogController extends Controller
{

    public function __construct(SiteLogService $site_log_service)
    {
        $this->site_log_service = $site_log_service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): Response
    {
        //$logs = LogTask::paginate(15);

        return response()->view('site_logs.index', [
            'logs' => $this->site_log_service->getAll(),
            'dates' => $this->site_log_service->getAllDates(),
            'logs_storage_link' => Storage::disk('site_logs')->url('logs'),
        ]);
    }

    public function show($id)
    {

        return view('logs.show')->with(['log' => LogTask::where('id', $id)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        LogTask::where('id', $id)->delete();
        return redirect()->route('logs.index');
    }
}
