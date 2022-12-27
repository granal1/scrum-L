<?php

namespace App\Policies\Admin;

use App\Models\Documents\Document;
use App\Models\Roles\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        foreach($user->roles as $role)
        {
            if($role->name === Role::DELO)
            {
                return true;
            }
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Documents\Document  $document
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user)
    {
        foreach($user->roles as $role)
        {
            if($role->name === Role::DELO)
            {
                return true;
            }
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        foreach($user->roles as $role)
        {
            if($role->name === Role::DELO)
            {
                return true;
            }
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
        foreach($user->roles as $role)
        {
            if($role->name === Role::DELO)
            {
                return true;
            }
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Documents\Document  $document
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user)
    {
        foreach($user->roles as $role)
        {
            if($role->name === Role::DELO)
            {
                return true;
            }
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Documents\Document  $document
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user)
    {
        foreach($user->roles as $role)
        {
            if($role->name === Role::DELO)
            {
                return true;
            }
        }
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Documents\Document  $document
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user)
    {
        foreach($user->roles as $role)
        {
            if($role->name === Role::DELO)
            {
                return true;
            }
        }
        return false;
    }
}
