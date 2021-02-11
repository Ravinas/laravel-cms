<?php

namespace CMS\Policies;

use CMS\Models\Page;
use CMS\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PagePolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        $this->module_id = CONTENT;
    }

    public function viewAny(User $user)
    {
        return $user->hasModulePermission($this->module_id,'C');
    }

    public function view(User $user )
    {
        return $user->hasModulePermission($this->module_id,'C');
    }

    public function create(User $user)
    {
        return $user->hasModulePermission($this->module_id,'C');
    }

    public function edit(User $user )
    {
        return $user->hasModulePermission($this->module_id,'C');
    }

    public function update(User $user )
    {
        return $user->hasModulePermission($this->module_id,'C');
    }

    public function delete(User $user )
    {
        return $user->hasModulePermission($this->module_id,'D');
    }

    public function restore(User $user )
    {
        return $user->hasModulePermission($this->module_id,'D');
    }

    public function forceDelete(User $user )
    {
        return $user->hasModulePermission($this->module_id,'D');
    }
}
