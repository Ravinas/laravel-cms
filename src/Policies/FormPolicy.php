<?php

namespace CMS\Policies;

use CMS\Models\Form;
use CMS\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FormPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        $this->module_id = FORM;
    }

    public function viewAny(User $user)
    {
        return $user->hasModulePermission($this->module_id,'C');
    }

    public function view(User $user, Form $form)
    {
        return $user->hasModulePermission($this->module_id,'C');
    }

    public function create(User $user)
    {
        return $user->hasModulePermission($this->module_id,'C');
    }

    public function edit(User $user, Form $form)
    {
        return $user->hasModulePermission($this->module_id,'C');
    }

    public function update(User $user, Form $form)
    {
        return $user->hasModulePermission($this->module_id,'C');
    }

    public function delete(User $user, Form $form)
    {
        return $user->hasModulePermission($this->module_id,'D');
    }

    public function restore(User $user, Form $form)
    {
        return $user->hasModulePermission($this->module_id,'D');
    }

    public function forceDelete(User $user, Form $form)
    {
        return $user->hasModulePermission($this->module_id,'D');
    }
}
