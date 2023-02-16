<?php

namespace App\Http\Controllers\Logs;

use App\Http\Controllers\Controller;
use App\Models\Logs\LogTask;


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
