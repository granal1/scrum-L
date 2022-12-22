<?php

namespace App\Http\Controllers\Tasks;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tasks\StoreTaskFormRequest;
use App\Http\Requests\Tasks\UpdateTaskFormRequest;
use App\Services\Tasks\UploadService;
use Illuminate\Http\Request;

use App\Models\Tasks\Task;
use App\Models\Tasks\TaskPriority;
use App\Models\User;
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTaskFormRequest $request, UploadService $uploadService)
    {
        $data = $request->validated();

        $task = Task::create($data);

        return redirect()->route('tasks.show', $task);
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
            'task' => $task
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
        if($request->isMethod('patch')){

            $data = $request->validated();

            $task->description = $data['description'];

            try {
                DB::beginTransaction();

                if( $task->save() ){

                    DB::commit();

                    return redirect()->route('tasks.index');
                }
            } catch (\Exception $e) {
                DB::rollBack();
                dd($e);
            }
        }
        return redirect()->route('tasks.show', $task->id);
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
}
