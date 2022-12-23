<?php

namespace App\Http\Controllers\Tasks;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tasks\StoreTaskFormRequest;
use App\Http\Requests\Tasks\UpdateTaskFormRequest;
use App\Models\Tasks\TaskHistory;
use App\Services\Tasks\UploadService;
use Illuminate\Http\Request;

use App\Models\Tasks\Task;
use App\Models\Tasks\TaskPriority;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
    public function index()
    {

        $tasks = Task::paginate(config('front.tasks.pagination'));

        return view('tasks.index',[
            'tasks' => $tasks,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tasks.create', [
            'priorities' => TaskPriority::all(),
            'users' => User::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_subtask(Task $task)
    {
        return view('tasks.create-subtask', [
            'priorities' => TaskPriority::all(),
            'users' => User::all(),
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
                DB::commit();

                return redirect()->route('tasks.show', $task)->with('success', 'Задача создана.');

            } catch (\Exception $e) {

                DB::rollBack();
                dd($e); // TODO сделать вывод ошибки в журнал, что сайт не крашился

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
        return view('tasks.show', [
            'task' => $task
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
        return view('tasks.edit', [
            'task' => $task,
            'priorities' => TaskPriority::all(),
            'users' => User::all()
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

                DB::commit();

                return redirect()->route('tasks.edit', $task)->with('success','Изменения сохранены.');

            } catch (\Exception $e) {

                DB::rollBack();
                dd($e); // TODO сделать вывод ошибки в журнал, что сайт не крашился

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
        $task->delete();
        return redirect()->route('tasks.index');
    }
}
