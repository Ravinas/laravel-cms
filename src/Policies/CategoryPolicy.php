<?php

namespace CMS\Policies;

use CMS\Models\Category;
use CMS\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        $this->module_id = CATEGORY;
    }

    public function viewAny(User $user)
    {
        return $user->hasModulePermission($this->module_id,'R');
    }
    public function view(User $user, Category $category)
    {
        return $user->hasModulePermission($this->module_id,'R');
    }

    public function create(User $user)
    {
        return $user->hasModulePermission($this->module_id,'C');
    }

    public function edit(User $user, Category $category)
    {
        return $user->hasModulePermission($this->module_id,'U');
    }

    public function update(User $user, Category $category)
    {
        return $user->hasModulePermission($this->module_id,'U');
    }

    public function delete(User $user, Category $category)
    {
        return $user->hasModulePermission($this->module_id,'D');
    }

    public function restore(User $user, Category $category)
    {
        return $user->hasModulePermission($this->module_id,'D');
    }

    public function forceDelete(User $user, Category $category)
    {
        return $user->hasModulePermission($this->module_id,'D');
    }
}
