<?php

namespace App\Http\Controllers\Tasks;

use App\Http\Controllers\Controller;

use App\Http\Filters\Tasks\TaskFilter;

use App\Jobs\ProcessSendMailToResponsible;
use App\Services\Tasks\TaskService;
use App\Http\Requests\Tasks\{ProgressTaskFormRequest, StoreTaskFormRequest, TaskFilterRequest, UpdateTaskFormRequest};

use App\Models\Documents\Document;
use App\Models\OutgoingFiles\OutgoingFile;

use App\Models\Tasks\{TaskFile, Task, TaskPriority};

use App\Models\User;

use App\Services\Tasks\UploadService;

use Illuminate\Support\Facades\{
    Auth,
    DB,
    Log
};

use Illuminate\Support\Str;
use Symfony\Polyfill\Uuid\Uuid;

use DateTime;

class TaskController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth']);
        $this->authorizeResource(Task::class, 'task');
        $this->service = new TaskService();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(TaskFilterRequest $request)
    {
        Log::info(
            get_class($this) . ', method: ' . __FUNCTION__,
            [
                'user' => Auth::user()->name,
                'request' => $request->all(),

            ]
        );

        $data = $request->validated();

        if (isset($data['description'])) {
            $data['description'] = no_inject($data['description']);
        }

        $filter = app()->make(TaskFilter::class, ['queryParams' => array_filter($data)]);

        $tasks = Task::filter($filter)
            ->where('author_uuid', Auth::id())
            ->orWhere('responsible_uuid', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(config('front.tasks.pagination'));

        foreach ($tasks as $key => $value) {
            $utcTime = new DateTime($value['deadline_at']);
            $value['deadline_at'] = $utcTime->setTimezone(timezone_open(session('localtimezone')))->format('d.m.Y H:i');
        }

        return view('tasks.index', [
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
        Log::info(
            get_class($this) . ', method: ' . __FUNCTION__,
            [
                'user' => Auth::user()->name,
            ]
        );

        $users = User::where('superior_uuid', 'like', Auth::id())->orWhere('id', 'like', Auth::id())->get();

        $documents = Document::orderBy('created_at', 'desc')->take(10)->get();

        return view('tasks.create', [
            'priorities' => TaskPriority::all(),
            'users' => $users,
            'documents' => $documents,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_subtask(Task $task)
    {
        Log::info(
            get_class($this) . ', method: ' . __FUNCTION__,
            [
                'user' => Auth::user()->name,
                'task' => $task->id,
            ]
        );

        $this->authorize('create', Task::class);

        $users = User::where('superior_uuid', 'like', Auth::id())->orWhere('id', 'like', Auth::id())->get();

        $documents = Document::orderBy('created_at', 'desc')->take(10)->get();

        return view('tasks.create-subtask', [
            'priorities' => TaskPriority::all(),
            'users' => $users,
            'task' => $task,
            'documents' => $documents,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTaskFormRequest $request, UploadService $uploadService)
    {
        Log::info(
            get_class($this) . ', method: ' . __FUNCTION__,
            [
                'user' => Auth::user()->name,
                'request' => $request->all(),
            ]
        );

        $this->authorize('create', Task::class);

        if ($request->isMethod('post')) {


            $data = $request->validated();
            $data['author_uuid'] = Auth::id();

            $localTime = new DateTime($data['deadline_at'], timezone_open(session('localtimezone')));   //Создание объекта даты в локальном поясе
            $data['deadline_at'] = $localTime->setTimezone(timezone_open('UTC')); //Сохранение в поясе UTC

            try {

                DB::beginTransaction();

                $task = Task::create($data);

                $real_document = Document::find($data['file_uuid']);

                if ($real_document) {
                    $task_file = TaskFile::create([
                        'task_uuid' => $task->id,
                        'file_uuid' => $real_document->id,
                    ]);
                }

                DB::commit();

                ProcessSendMailToResponsible::dispatch($task)
                    ->onQueue('tasks');

                $task = $task->parent_uuid ?? $task;

                return redirect()->route('tasks.show', $task)->with('success', 'Задача создана.');

            } catch (\Exception $e) {
                DB::rollBack();
                Log::error($e);
            }
        }
        return redirect()->route('tasks.create')->with('error', 'Ошибка при создании задачи.');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        Log::info(
            get_class($this) . ', method: ' . __FUNCTION__,
            [
                'user' => Auth::user()->name,
                'task' => $task->id,
            ]
        );

        $utcTime = new DateTime($task['deadline_at']);
        $task['deadline_at'] = $utcTime->setTimezone(timezone_open(session('localtimezone')))->format('d.m.Y H:i'); // перевод влокальный часовой пояс
        $utcTime = new DateTime($task['created_at']);
        $task['created_at'] = $utcTime->setTimezone(timezone_open(session('localtimezone')))->format('d.m.Y H:i'); // перевод влокальный часовой пояс

        return view('tasks.show', [
            'task' => $task,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        Log::info(
            get_class($this) . ', method: ' . __FUNCTION__,
            [
                'user' => Auth::user()->name,
                'task' => $task->id,

            ]
        );

        $utcTime = new DateTime($task['deadline_at']);
        $task['deadline_at'] = $utcTime->setTimezone(timezone_open(session('localtimezone')))->format('d.m.Y H:i'); // перевод влокальный часовой пояс

        return view('tasks.edit', [
            'task' => $task,
            'priorities' => TaskPriority::all(),
            'users' => User::where('superior_uuid', 'like', Auth::id())->orWhere('id', 'like', Auth::id())->get(),
            'documents' => Document::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTaskFormRequest $request, Task $task)
    {
        Log::info(
            get_class($this) . ', method: ' . __FUNCTION__,
            [
                'user' => Auth::user()->name,
                'task' => $task->id,
                'request' => $request->all(),
            ]
        );

        if ($request->isMethod('patch')) {

            $data = $request->validated();
            $localTime = new DateTime($data['deadline_at'], timezone_open(session('localtimezone')));   //Создание объекта даты в локальном поясе
            $data['deadline_at'] = $localTime->setTimezone(timezone_open('UTC'));                       //Сохранение в поясе UTC

            try {

                DB::beginTransaction();

                $task->update([
                    'priority_uuid' => $data['priority_uuid'],
                    'responsible_uuid' => $data['responsible_uuid'],
                    'description' => $data['description'],
                    'deadline_at' => $data['deadline_at'],
                    'done_progress' => $data['done_progress'] ?? $task->done_progress,
                    'report' => $data['report'] ?? $task->report,
                    'repeat_value' => $data['repeat_value'],
                    'repeat_period' => $data['repeat_period'],
                ]);

                $real_document = Document::find($data['file_uuid']);

                if ($real_document) {
                    $task_file = TaskFile::create([
                        'task_uuid' => $task->id,
                        'file_uuid' => $real_document->id,
                    ]);
                }

                DB::commit();

                return redirect()->route('tasks.edit', $task)->with('success', 'Изменения сохранены.');

            } catch (\Exception $e) {

                DB::rollBack();
                Log::error($e);
            }
        }

        return redirect()->route('tasks.edit', $task)->with('error', 'Изменения не сохранились, ошибка.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Task $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        Log::info(
            get_class($this) . ', method: ' . __FUNCTION__,
            [
                'user' => Auth::user()->name,
                'task' => $task->id,
            ]
        );

        $task->delete();
        return redirect()->route('tasks.index');
    }

    public function task_file_destroy(Task $task, Document $document)
    {
        Log::info(
            get_class($this) . ', method: ' . __FUNCTION__,
            [
                'user' => Auth::user()->name,
                'task' => $task->id,
                'document' => $document->id,
            ]
        );

        $this->authorize('delete', Task::class);

        $task_file = TaskFile::where('task_uuid', $task->id)->where('file_uuid', $document->id)->delete();

        return redirect()->route('tasks.show', $task);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function progress(Task $task)
    {
        Log::info(
            get_class($this) . ', method: ' . __FUNCTION__,
            [
                'user' => Auth::user()->name,
                'task' => $task->id,

            ]
        );

        $this->authorize('view', Task::class);

        $utcTime = new DateTime($task['deadline_at']);
        $task['deadline_at'] = $utcTime->setTimezone(timezone_open(session('localtimezone')))->format('d.m.Y H:i'); // перевод влокальный часовой пояс
        $utcTime = new DateTime($task['created_at']);
        $task['created_at'] = $utcTime->setTimezone(timezone_open(session('localtimezone')))->format('d.m.Y H:i'); // перевод влокальный часовой пояс

        return view('tasks.progress', [
            'task' => $task,
            'priorities' => TaskPriority::all(),
            'users' => User::all(),
            'documents' => Document::all(),
            'outgoing_documents' => OutgoingFile::where('executor_uuid', Auth::id())->get(),
        ]);
    }

    /**
     * Progress the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function progress_update(ProgressTaskFormRequest $request, Task $task)
    {
        Log::info(
            get_class($this) . ', method: ' . __FUNCTION__,
            [
                'user' => Auth::user()->name,
                'task' => $task->id,
                'request' => $request->all(),
            ]
        );

        $this->authorize('update', $task);

        if ($request->isMethod('patch')) {

            $data = $request->validated();

            try {

                DB::beginTransaction();

                $task->update([
                    'done_progress' => $data['done_progress'],
                    'report' => $data['comment'],
                ]);

                if ($task->done_progress == 100) {
                    foreach ($task->documents as $document) {

                        $document->update([
                            'executed_result' => $task->report,
                            'executed_at' => date('Y-m-d H:i:s')
                        ]);

                    }

                    if (isset($data['create_new_task'])) {
                        $new_task = $task->replicate();
                        $new_task->done_progress = 0;
                        $new_task->report = null;
                        $new_task->comment = null;

                        $old_deadline = new DateTime($task->deadline_at);
                        $old_deadline->modify('+' . $task->repeat_value . ' ' . $task->repeat_period);
                        $new_task->deadline_at = $old_deadline;

                        $new_task->push();
                    }

                    $task_files = TaskFile::where('task_uuid', $task->id)->get();

                    if ($task_files) {
                        foreach ($task_files as $task_file)
                            $task_file->update([
                                'outgoing_file_uuid' => $data['outgoing_file_uuid'],
                            ]);
                    }
                }

                DB::commit();

                return redirect()->route('tasks.show', $task)->with('success', 'Изменения сохранены.');
            } catch (\Exception $e) {

                DB::rollBack();
                Log::error($e);
            }
        }

        return redirect()->route('tasks.show', $task)->with('error', 'Изменения не сохранились, ошибка.');
    }
}
