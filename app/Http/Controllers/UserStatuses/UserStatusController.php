<?php

namespace App\Http\Controllers\UserStatuses;

use App\Http\Controllers\Controller;
use App\Http\Filters\Users\UserStatusFilter;
use App\Http\Filters\UserStatuses\RoleFilter;
use App\Http\Requests\UserStatuses\RoleFilterRequest;
use App\Http\Requests\UserStatuses\StoreRoleFormRequest;
use App\Http\Requests\UserStatuses\StoreUserStatusFormRequest;
use App\Http\Requests\UserStatuses\UpdateRoleFormRequest;
use App\Http\Requests\UserStatuses\UpdateUserStatusFormRequest;
use App\Http\Requests\UserStatuses\UserStatusFilterRequest;
use App\Models\UserStatuses\Role;
use App\Models\UserStatuses\UserStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UserStatusController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->authorizeResource(UserStatus::class, 'user_status');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UserStatusFilterRequest $request)
    {
        Log::info(get_class($this) . ', method: ' . __FUNCTION__,
            [
                'user' => Auth::user()->name,
                'request' => $request->all(),

            ]);

        //$this->authorize('viewAny', UserStatus::class);

        $data = $request->validated();
 
        if (isset($data['name'])) {
            $data['name'] = (string) Str::of($data['name'])
                ->lower()
                ->remove(config('stop-list'))
                ->ltrim(' ')
                ->rtrim(' ')
                ->replace('  ', "");
        }

        if (isset($data['alias'])) {
            $data['alias'] = (string) Str::of($data['alias'])
                ->lower()
                ->remove(config('stop-list'))
                ->ltrim(' ')
                ->rtrim(' ')
                ->replace('  ', "");
        }
        
        $filter = app()->make(UserStatusFilter::class, ['queryParams' => array_filter($data)]);

        $user_statuses = UserStatus::filter($filter)
            ->paginate(config('front.user_statuses.pagination'));

        return view('user_statuses.index', [
            'user_statuses' => $user_statuses,
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
        //$this->authorize('create', UserStatus::class);

        return view('user_statuses.create', [
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserStatusFormRequest $request)
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

                $task = UserStatus::create($data);

                DB::commit();

                return redirect()->route('user_statuses.show', $task)->with('success', 'Роль создана.');

            } catch (\Exception $e) {
                DB::rollBack();
                Log::error($e);
            }
        }

        return redirect()->route('user_statuses.show', $task)->with('error', 'Ошибка при создании роли.');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(UserStatus $user_status)
    {
        //$this->authorize('view', UserStatus::class);

        return view('user_statuses.show', [
            'user_status' => $user_status
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(UserStatus $user_status)
    {
        Log::info(get_class($this) . ', method: ' . __FUNCTION__,
            [
                'user' => Auth::user()->name,
                'user_status' => $user_status->id,

            ]);

        return view('user_statuses.edit', [
            'user_status' => $user_status,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserStatusFormRequest $request, UserStatus $user_status)
    {
        Log::info(get_class($this) . ', method: ' . __FUNCTION__,
            [
                'user' => Auth::user()->name,
                'user_status' => $user_status->id,
                'request' => $request->all(),
            ]);

        if($request->isMethod('patch')) {

            $data = $request->validated();

            try {

                DB::beginTransaction();

                $user_status->update([
                    'alias' => $data['alias'],
                    'name' => $data['name'],
                ]);

                DB::commit();

                return redirect()->route('user_statuses.edit', $user_status)->with('success','Изменения сохранены.');

            } catch (\Exception $e) {

                DB::rollBack();
                Log::error($e);
            }

        }

        return redirect()->route('user_statuses.edit', $user_status)->with('error','Изменения не сохранились, ошибка.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserStatus $user_status)
    {
        Log::info(get_class($this) . ', method: ' . __FUNCTION__,
            [
                'user' => Auth::user()->name,
                'user_status' => $user_status->id,
            ]);

        $user_status->delete();
        return redirect()->route('user_statuses.index');
    }
}
