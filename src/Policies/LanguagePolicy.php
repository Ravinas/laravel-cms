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

    }

    public function viewAny(User $user)
    {
        return $user->hasModulePermission();
    }

    public function view(User $user,Language $language)
    {
        return $user->hasModulePermission();
    }

    public function create(User $user)
    {
        return $user->hasModulePermission();
    }

    public function edit(User $user,Language $language)
    {
        return $user->hasModulePermission();
    }

    public function update(User $user,Language $language)
    {
        return $user->hasModulePermission();
    }

    public function delete(User $user,Language $language)
    {
        return $user->hasModulePermission();
    }

    public function restore(User $user,Language $language)
    {
        return $user->hasModulePermission();
    }

    public function forceDelete(User $user,Language $language)
    {
        return $user->hasModulePermission();
    }
}
