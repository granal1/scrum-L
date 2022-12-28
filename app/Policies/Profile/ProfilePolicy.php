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
     * @param  \App\Models\User  $user
     * @param  \App\Models\Documents\Document  $document
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user)
    {
        if($user->id === Auth::id())
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Documents\Document  $document
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user)
    {
        if($user->id === Auth::id())
        {
            return true;
        }
        return false;
    }
}
