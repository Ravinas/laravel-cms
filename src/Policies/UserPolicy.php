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

    public function view(User $user )
    {
        return $user->hasModulePermission();
    }

    public function create(User $user)
    {
        return $user->hasModulePermission();
    }

    public function edit(User $user )
    {
        return $user->hasModulePermission();
    }

    public function update(User $user )
    {
        return $user->hasModulePermission();
    }

    public function delete(User $user )
    {
        return $user->hasModulePermission();
    }

    public function restore(User $user )
    {
        return $user->hasModulePermission();
    }

    public function forceDelete(User $user )
    {
        return $user->hasModulePermission();
    }
}
