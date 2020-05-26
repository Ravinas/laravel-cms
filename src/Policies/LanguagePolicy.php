<?php

namespace CMS\Policies;

use CMS\Models\Language;
use CMS\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LanguagePolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        $this->module_id = LANGUAGE;
    }

    public function viewAny(User $user)
    {
        return $user->hasModulePermission($this->module_id,'R');
    }

    public function view(User $user,Language $language)
    {
        return $user->hasModulePermission($this->module_id,'R');
    }

    public function create(User $user)
    {
        return $user->hasModulePermission($this->module_id,'C');
    }

    public function update(User $user,Language $language)
    {
        return $user->hasModulePermission($this-> module_id,'U');
    }

    public function delete(User $user,Language $language)
    {
        return $user->hasModulePermission($this->module_id,'D');
    }

    public function restore(User $user,Language $language)
    {
        return $user->hasModulePermission($this->module_id,'D');
    }

    public function forceDelete(User $user,Language $language)
    {
        return $user->hasModulePermission($this->module_id,'D');
    }
}
