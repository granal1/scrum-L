<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tasks\StoreTaskFormRequest;
use App\Http\Requests\Tasks\UpdateTaskFormRequest;
use App\Services\Tasks\UploadService;
use Illuminate\Http\Request;

use App\Models\Tasks\Task;
use App\Models\Tasks\TaskPriority;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Symfony\Polyfill\Uuid\Uuid;


class UserController extends Controller
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

//       $tasks = User::paginate(config('front.users.pagination'));

       return view('users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create', [
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserFormRequest $request, UploadService $uploadService)
    {
//        $data = $request->validated();
//
//        $task = Task::create($data);
//
//        return redirect()->route('tasks.show', $task);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
//        return view('tasks.show', [
//            'task' => $task
//        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
//        return view('tasks.edit', [
//            'task' => $task
//        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserFormRequest $request, User $user)
    {
//        if($request->isMethod('patch')){
//
//            $data = $request->validated();
//
//            $task->description = $data['description'];
//
//            try {
//                DB::beginTransaction();
//
//                if( $task->save() ){
//
//                    DB::commit();
//
//                    return redirect()->route('tasks.index');
//                }
//            } catch (\Exception $e) {
//                DB::rollBack();
//                dd($e);
//            }
//        }
//        return redirect()->route('tasks.show', $task->id);
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
