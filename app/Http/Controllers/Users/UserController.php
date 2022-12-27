<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Filters\Users\UserFilter;
use App\Http\Requests\Users\StoreUserFormRequest;
use App\Http\Requests\Users\UpdateUserFormRequest;
use App\Http\Requests\Users\UserFilterRequest;
use App\Models\UserRoles\UserRole;

use App\Models\Roles\Role;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
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
    public function index(UserFilterRequest $request)
    {
        Log::info(get_class($this) . ', method: ' . __FUNCTION__,
            [
                'user' => Auth::user()->name,
                'request' => $request->all(),

            ]);

        //$this->authorize('viewAny', User::class);

        $data = $request->validated();

        $filter = app()->make(UserFilter::class, ['queryParams' => array_filter($data)]);

        $users = User::filter($filter)
            ->paginate(config('front.users.pagination'));

        return view('users.index',[
            'users' => $users,
            'old_filters' => $data,
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

        //$this->authorize('create', User::class);

        return view('users.create', [
            'superiors' => User::all(),
            'roles' => Role::all(),
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
        Log::info(get_class($this) . ', method: ' . __FUNCTION__,
            [
                'user' => Auth::user()->name,
                'request' => $request->all(),

            ]);

        //$this->authorize('create', User::class);

        if ($request->isMethod('post'))
        {
            $data = $request->validated();

            $user = new User();

            try {

                DB::beginTransaction();

                $user->fill([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'superior_uuid' => $data['superior_uuid'],
                    'phone' => $data['phone'],
                    'birthday_at' => $data['birthday_at'],
                    'password' => Hash::make($data['password'])
                ]);

                $user->save();

                UserRole::create([
                    'user_uuid' => $user->id,
                    'role_uuid' => $data['role_uuid'],
                ]);

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
                Log::error($e);            }
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
        Log::info(get_class($this) . ', method: ' . __FUNCTION__,
            [
                'user' => Auth::user()->name,
                //'user_request_data' => $user
            ]);

        //$this->authorize('view', User::class);

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
        Log::info(get_class($this) . ', method: ' . __FUNCTION__,
            [
                'user' => Auth::user()->name,
            ]);

        //$this->authorize('update', User::class);

        return view('users.edit', [
            'user' => $user,
            'superiors' => User::all(),
            'subordinates' => User::all(),
            'roles' => Role::all(),
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
        Log::info(get_class($this) . ', method: ' . __FUNCTION__,
            [
                'user' => Auth::user()->name,
                'request' => $request->all(),

            ]);

        //$this->authorize('update', User::class);

        if($request->isMethod('patch')){

            $data = $request->validated();

            try {
                DB::beginTransaction();

                $user->update([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    //'password' => $data['password'] ? Hash::make($data['password']) : $user->password,
                    'phone' => $data['phone'],
                    'birthday_at' => $data['birthday_at'],
                    'superior_uuid' => $data['superior_uuid']
                ]);

                UserRole::where('user_uuid', $user->id)->delete();
                UserRole::create([
                    'user_uuid' => $user->id,
                    'role_uuid' => $data['role_uuid'],
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
                Log::error($e);            }
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
        Log::info(get_class($this) . ', method: ' . __FUNCTION__,
            [
                'user' => Auth::user()->name,
            ]);

        //$this->authorize('delete', User::class);

        $user->delete();
        return redirect()->route('users.index');
    }
}
