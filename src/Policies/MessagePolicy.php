<?php

namespace CMS\Policies;

use CMS\Models\Message;
use CMS\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MessagePolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        $this->module_id = FORM;
    }

    public function viewAny(User $user)
    {
        return $user->hasModulePermission($this->module_id,'R');
    }

    public function view(User $user, Message $message)
    {
        return $user->hasModulePermission($this->module_id,'R');
    }

    public function create(User $user)
    {
        return true;
    }

    public function edit(User $user, Message $message)
    {
        return $user->hasModulePermission($this->module_id,'U');
    }

    public function update(User $user, Message $message)
    {
        return $user->hasModulePermission($this->module_id,'U');
    }

    public function delete(User $user, Message $message)
    {
        return $user->hasModulePermission($this->module_id,'D');
    }

    public function restore(User $user, Message $message)
    {
        return $user->hasModulePermission($this->module_id,'D');
    }

    public function forceDelete(User $user, Message $message)
    {
        return $user->hasModulePermission($this->module_id,'D');
    }
}
