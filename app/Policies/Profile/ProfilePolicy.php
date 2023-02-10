<?php

namespace App\Policies\Profile;

use App\Models\Documents\Document;
use App\Models\Roles\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class ProfilePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user)
    {
        foreach ($user->roles as $role) {
            if ($role->name === Role::ADMIN || $role->name === Role::KADR) {
                return true;
            }
        }
        return false;
    }
}
