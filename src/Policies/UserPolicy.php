<?php

namespace CMS\Policies;

use CMS\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;


    public function viewAny(User $user)
    {
        return $user->hasModulePermission();
    }

    public function view(User $user, User $model)
    {
        return $user->hasModulePermission();
    }

    public function create(User $user)
    {
        return $user->hasModulePermission();
    }

    public function edit(User $user, User $model)
    {
        return $user->hasModulePermission();
    }

    public function update(User $user, User $model)
    {
        return $user->hasModulePermission();
    }

    public function delete(User $user, User $model)
    {
        return $user->hasModulePermission();
    }

    public function restore(User $user, User $model)
    {
        return $user->hasModulePermission();
    }

    public function forceDelete(User $user, User $model)
    {
        return $user->hasModulePermission();
    }
}
