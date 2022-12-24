<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tasks\StoreTaskFormRequest;
use App\Http\Requests\Tasks\UpdateTaskFormRequest;
use App\Http\Requests\Users\StoreUserFormRequest;
use App\Http\Requests\Users\UpdateUserFormRequest;
use App\Services\Tasks\UploadService;
use Illuminate\Http\Request;

use App\Models\Tasks\Task;
use App\Models\Tasks\TaskPriority;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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

        $users = User::paginate(config('front.users.pagination'));

        return view('users.index',[
            'users' => $users,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create', [
            'superiors' => User::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserFormRequest $request)
    {
        if ($request->isMethod('post'))
        {
            $data = $request->validated();

            $user = new User();

            try {

                DB::beginTransaction();

                $user->fill([
                    'name' => $data['name'],
                    'login' => $data['login'],
                    'email' => $data['email'],
                    'superior_uuid' => $data['superior_uuid'],
                    'phone' => $data['phone'],
                    'birthday_at' => $data['birthday_at'],
                    'password' => Hash::make($data['password'])
                ]);

                $user->save();

                if(isset($data['subordinate_uuid']) && !empty($data['subordinate_uuid']))
                {
                    $subordinate_user = User::find($data['subordinate_uuid']);

                    $subordinate_user->update([
                        'superior_uuid' => $user->id,
                    ]);
                }

                DB::commit();

                return redirect()->route('users.show', $user)->with('success', 'Новый сотрудник создан.');

            } catch (\Exception $e) {
                DB::rollBack();
                dd($e); // TODO сделать вывод в журнол ошибок, чтобы сайт не крашился
            }
        }

        return redirect()->route('users.create')->with('error', 'Не удалось создать нового сотрудника.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('users.show', [
            'user' => $user,
            'subordinates' => User::where('superior_uuid', $user->id)->get(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('users.edit', [
            'user' => $user,
            'superiors' => User::all(),
            'subordinates' => User::all(),
        ]);
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
        if($request->isMethod('patch')){

            $data = $request->validated();

            try {
                DB::beginTransaction();

                $user->update([
                    'name' => $data['name'],
                    'login' => $data['login'],
                    'email' => $data['email'],
                    //'password' => $data['password'] ? Hash::make($data['password']) : $user->password,
                    'phone' => $data['phone'],
                    'birthday_at' => $data['birthday_at'],
                    'superior_uuid' => $data['superior_uuid']
                ]);

                if(isset($data['subordinate_uuid']) && !empty($data['subordinate_uuid']))
                {
                    $subordinate_user = User::find($data['subordinate_uuid']);

                    $subordinate_user->update([
                        'superior_uuid' => $user->id,
                    ]);
                }

                    DB::commit();

                    return redirect()->route('users.edit', $user->id)->with('success', 'Новые данные сотрудника сохранены.');

            } catch (\Exception $e) {
                DB::rollBack();
                dd($e); // TODO, вывод ошибки в журнал, чтобы сайт не крашился
            }
        }
        return redirect()->route('users.edit', $user->id)->with('error', 'Не удалось сохранить новые данные.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index');
    }
}
