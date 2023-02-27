<?php

namespace App\Http\Controllers\Logs;

use App\Http\Controllers\Controller;
use App\Models\Logs\LogTask;
use Illuminate\Support\Facades\Log;

class LogsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $logs = LogTask::paginate(15);


        return view('logs.index')->with(['logs' => $logs]);
    }

    public function show(LogTask $log)
    {
        return view('logs.show')->with(['log' => $log]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (LogTask::destroy($id)) {
            return response()->json([
                'message' => 'log deleted',
                'status_code' => 200
            ], 200);
        } else {
            return response()->json([
                'message' => 'log deleted error',
                'status_code' => 500
            ], 500);
        }
    }
}
