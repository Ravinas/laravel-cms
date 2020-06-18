<?php

namespace CMS\Policies;

use CMS\Models\Redirect;
use CMS\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RedirectPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        $this->module_id = REDIRECT;
    }

    public function viewAny(User $user)
    {
        return $user->hasModulePermission($this->module_id,'R');
    }

    public function view(User $user, Redirect $redirect)
    {
        return $user->hasModulePermission($this->module_id,'R');
    }

    public function create(User $user)
    {
        return $user->hasModulePermission($this->module_id,'C');
    }

    public function edit(User $user, Redirect $redirect)
    {
        return $user->hasModulePermission($this->module_id,'U');
    }

    public function update(User $user, Redirect $redirect)
    {
        return $user->hasModulePermission($this->module_id,'U');
    }

    public function delete(User $user, Redirect $redirect)
    {
        return $user->hasModulePermission($this->module_id,'D');
    }

    public function restore(User $user, Redirect $redirect)
    {
        return $user->hasModulePermission($this->module_id,'D');
    }

    public function forceDelete(User $user, Redirect $redirect)
    {
        return $user->hasModulePermission($this->module_id,'D');
    }
}
