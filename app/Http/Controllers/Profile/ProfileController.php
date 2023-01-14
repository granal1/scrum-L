<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Filters\Users\UserFilter;
use App\Http\Requests\Profile\UpdateProfileFormRequest;
use App\Http\Requests\Users\StoreUserFormRequest;
use App\Http\Requests\Users\UpdateUserFormRequest;
use App\Http\Requests\Users\UserFilterRequest;
use App\Models\Profile\Profile;
use App\Models\UserRoles\UserRole;

use App\Models\Roles\Role;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Symfony\Polyfill\Uuid\Uuid;


class ProfileController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth']);
        //$this->authorizeResource(Profile::class, 'profile');
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

        $this->authorize('view', Profile::class);

        return view('profile.show', [
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

        $this->authorize('update', Profile::class);

        return view('profile.edit', [
            'user' => $user,
            'superiors' => User::all(),
            'subordinates' => User::where('superior_uuid', $user->id)->get(),
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
    public function update(UpdateProfileFormRequest $request, User $user)
    {
        Log::info(get_class($this) . ', method: ' . __FUNCTION__,
            [
                'user' => Auth::user()->name,
                'request' => $request->all(),

            ]);

        $this->authorize('update', Profile::class);

        if($request->isMethod('patch')){

            $data = $request->validated();

            try {
                DB::beginTransaction();

                $user->update([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => $data['password'] ? Hash::make($data['password']) : $user->password,
                    'phone' => $data['phone'],
                    'birthday_at' => $data['birthday_at'],
                    'superior_uuid' => $data['superior_uuid']
                ]);

                    DB::commit();

                    return redirect()->route('profile.edit', $user->id)->with('success', 'Новые данные сотрудника сохранены.');

            } catch (\Exception $e) {
                DB::rollBack();
                Log::error($e);            }
        }
        return redirect()->route('profile.edit', $user->id)->with('error', 'Не удалось сохранить новые данные.');
    }

}
