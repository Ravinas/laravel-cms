<?php

namespace CMS\Policies;

use CMS\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;


    public function viewAny(User $user)
    {
        return ($user->role_id <= 2 ? true : false );
    }

    public function view(User $user, User $model)
    {
        return ($user->role_id <= 2 ? true : false );
    }

    public function create(User $user)
    {
        return ($user->role_id <= 2 ? true : false );
    }

    public function update(User $user, User $model)
    {
        return ($user->role_id <= 2 ? true : false );
    }

    public function delete(User $user, User $model)
    {
        return ($user->role_id <= 2 ? true : false );
    }

    public function restore(User $user, User $model)
    {
        return ($user->role_id <= 2 ? true : false );
    }

    public function forceDelete(User $user, User $model)
    {
        return ($user->role_id <= 2 ? true : false );
    }
}
