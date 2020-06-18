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
        return ($user->role_id <= 2 ? true : false );
    }

    public function view(User $user, Role $role)
    {
        return ($user->role_id <= 2 ? true : false );
    }

    public function create(User $user)
    {
        return ($user->role_id <= 2 ? true : false );
    }

    public function edit(User $user, Role $role)
    {
        return ($user->role_id <= 2 ? true : false );
    }

    public function update(User $user, Role $role)
    {
        return ($user->role_id <= 2 ? true : false );
    }

    public function delete(User $user, Role $role)
    {
        return ($user->role_id <= 2 ? true : false );
    }

    public function restore(User $user, Role $role)
    {
        return ($user->role_id <= 2 ? true : false );
    }

    public function forceDelete(User $user, Role $role)
    {
        return ($user->role_id <= 2 ? true : false );
    }
}
