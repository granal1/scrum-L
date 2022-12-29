<?php

namespace App\Http\Controllers\Tasks;

use App\Http\Controllers\Controller;

use App\Http\Filters\Tasks\TaskFilter;

use App\Http\Filters\Tasks\TaskHistoryFilter;
use App\Http\Requests\Tasks\{ProgressTaskFormRequest, StoreTaskFormRequest, TaskFilterRequest, UpdateTaskFormRequest};

use App\Models\Documents\Document;

use App\Models\Tasks\
{
    TaskFile,
    TaskHistory,
    Task,
    TaskPriority
};

use App\Models\User;

use App\Services\Tasks\UploadService;

use Illuminate\Support\Facades\
{
    Auth,
    DB,
    Log
};

use Symfony\Polyfill\Uuid\Uuid;

class TaskController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(TaskFilterRequest $request)
    {
        Log::info(get_class($this) . ', method: ' . __FUNCTION__,
                            [
                                'user' => Auth::user()->name,
                                'request' => $request->all(),

                            ]);

        $data = $request->validated();

        $filter = app()->make(TaskHistoryFilter::class, ['queryParams' => array_filter($data)]);
        $histories = TaskHistory::filter($filter)->pluck('task_uuid')->all();

        $filter = app()->make(TaskFilter::class, ['queryParams' => array_filter($data)]);

        $tasks = Task::filter($filter)
            ->whereIn('id', $histories)
            ->paginate(config('front.tasks.pagination'));

        return view('tasks.index',[
            'tasks' => $tasks,
            'old_filters' => $data,
            'priorities' => TaskPriority::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Log::info(get_class($this) . ', method: ' . __FUNCTION__,
            [
                'user' => Auth::user()->name,
            ]);

        $users = User::where('superior_uuid', 'like', Auth::id())->orWhere('id', 'like', Auth::id())->get();

        return view('tasks.create', [
            'priorities' => TaskPriority::all(),
            'users' => $users,
            'documents' => Document::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_subtask(Task $task)
    {
        Log::info(get_class($this) . ', method: ' . __FUNCTION__,
            [
                'user' => Auth::user()->name,
                'task' => $task->id,
            ]);

        $users = User::where('superior_uuid', 'like', Auth::id())->orWhere('id', 'like', Auth::id())->get();

        return view('tasks.create-subtask', [
            'priorities' => TaskPriority::all(),
            'users' => $users,
            'task' => $task
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTaskFormRequest $request, UploadService $uploadService)
    {
        Log::info(get_class($this) . ', method: ' . __FUNCTION__,
            [
                'user' => Auth::user()->name,
                'request' => $request->all(),
            ]);

        if($request->isMethod('post')) {

            $data = $request->validated();

            try {

                DB::beginTransaction();
                $task = Task::create($data);

                $history = TaskHistory::create([
                    'task_uuid' => $task->id,
                    'priority_uuid' => $data['priority_uuid'],
                    'user_uuid' => Auth::id(),
                    'responsible_uuid' => $data['responsible_uuid'],
                    'deadline_at' => $data['deadline_at'],
                    'parent_uuid' => $data['parent_uuid'] ?? null,
                ]);

                $real_document = Document::find($data['file_uuid']);

                if($real_document)
                {
                    $task_file = TaskFile::create([
                        'task_uuid' => $task->id,
                        'file_uuid' => $real_document->id,
                    ]);
                }

                DB::commit();

                return redirect()->route('tasks.show', $task)->with('success', 'Задача создана.');

            } catch (\Exception $e) {
                DB::rollBack();
                Log::error($e);
            }
        }

        return redirect()->route('tasks.show', $task)->with('error', 'Ошибка при создании задачи.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        Log::info(get_class($this) . ', method: ' . __FUNCTION__,
            [
                'user' => Auth::user()->name,
                'task' => $task->id,
            ]);

        return view('tasks.show', [
            'task' => $task,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        Log::info(get_class($this) . ', method: ' . __FUNCTION__,
            [
                'user' => Auth::user()->name,
                'task' => $task->id,

            ]);

        return view('tasks.edit', [
            'task' => $task,
            'priorities' => TaskPriority::all(),
            'users' => User::all(),
            'documents' => Document::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTaskFormRequest $request, Task $task)
    {
        Log::info(get_class($this) . ', method: ' . __FUNCTION__,
            [
                'user' => Auth::user()->name,
                'task' => $task->id,
                'request' => $request->all(),
            ]);

        if($request->isMethod('patch')) {

            $data = $request->validated();

            try {

                DB::beginTransaction();

                $task->update([
                    'description' => $data['description']
                ]);

                $history = TaskHistory::create([
                    'task_uuid' => $task->id,
                    'priority_uuid' => $data['priority_uuid'],
                    'user_uuid' => Auth::id(),
                    'responsible_uuid' => $data['responsible_uuid'],
                    'deadline_at' => $data['deadline_at'],
                    'done_progress' => $data['done_progress'],
                    'parent_uuid' => null,
                    'comment' => $data['comment']
                ]);

                $real_document = Document::find($data['file_uuid']);

                if($real_document)
                {
                    $task_file = TaskFile::create([
                        'task_uuid' => $task->id,
                        'file_uuid' => $real_document->id,
                    ]);
                }

                DB::commit();

                return redirect()->route('tasks.edit', $task)->with('success','Изменения сохранены.');

            } catch (\Exception $e) {

                DB::rollBack();
                Log::error($e);
            }

        }

        return redirect()->route('tasks.edit', $task)->with('error','Изменения не сохранились, ошибка.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        Log::info(get_class($this) . ', method: ' . __FUNCTION__,
            [
                'user' => Auth::user()->name,
                'task' => $task->id,
            ]);

        $task->delete();
        return redirect()->route('tasks.index');
    }

    public function task_file_destroy(Task $task, Document $document)
    {
        Log::info(get_class($this) . ', method: ' . __FUNCTION__,
            [
                'user' => Auth::user()->name,
                'task' => $task->id,
                'document' => $document->id,
            ]);

        $task_file = TaskFile::where('task_uuid', $task->id)->where('file_uuid', $document->id)->delete();

        return redirect()->route('tasks.show', $task);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function progress(Task $task)
    {
        Log::info(get_class($this) . ', method: ' . __FUNCTION__,
            [
                'user' => Auth::user()->name,
                'task' => $task->id,

            ]);

        return view('tasks.progress', [
            'task' => $task,
            'priorities' => TaskPriority::all(),
            'users' => User::all(),
            'documents' => Document::all(),
        ]);
    }

    /**
     * Progress the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function progress_update(ProgressTaskFormRequest $request, Task $task)
    {
        Log::info(get_class($this) . ', method: ' . __FUNCTION__,
            [
                'user' => Auth::user()->name,
                'task' => $task->id,
                'request' => $request->all(),
            ]);

        if($request->isMethod('patch')) {

            $data = $request->validated();

            try {

                DB::beginTransaction();

                $history = TaskHistory::create([
                    'task_uuid' => $task->id,
                    'priority_uuid' => $task->currentHistory->priority_uuid,
                    'user_uuid' => Auth::id(),
                    'responsible_uuid' => $task->currentHistory->responsible_uuid,
                    'deadline_at' => $task->currentHistory->deadline_at,
                    'done_progress' => $data['done_progress'],
                    'parent_uuid' => $task->currentHistory->parent_uuid,
                    'comment' => $data['comment']
                ]);

                DB::commit();

                return redirect()->route('tasks.show', $task)->with('success','Изменения сохранены.');

            } catch (\Exception $e) {

                DB::rollBack();
                Log::error($e);
            }

        }

        return redirect()->route('tasks.show', $task)->with('error','Изменения не сохранились, ошибка.');
    }
}
