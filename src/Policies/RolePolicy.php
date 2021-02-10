<?php

namespace CMS\Policies;

use CMS\Models\Role;
use CMS\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->hasModulePermission();
    }

    public function view(User $user, Role $role)
    {
        return $user->hasModulePermission();
    }

    public function create(User $user)
    {
        return $user->hasModulePermission();
    }

    public function edit(User $user, Role $role)
    {
        return $user->hasModulePermission();
    }

    public function update(User $user, Role $role)
    {
        return $user->hasModulePermission();
    }

    public function delete(User $user, Role $role)
    {
        return $user->hasModulePermission();
    }

    public function restore(User $user, Role $role)
    {
        return $user->hasModulePermission();
    }

    public function forceDelete(User $user, Role $role)
    {
        return $user->hasModulePermission();
    }
}
