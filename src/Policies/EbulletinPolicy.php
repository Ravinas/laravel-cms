<?php

namespace CMS\Policies;

use CMS\Models\BaseModel;
use CMS\Models\Ebulletin;
use CMS\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EbulletinPolicy
{
    use HandlesAuthorization;
    public function __construct()
    {
        $this->module_id = EBULLETIN;
    }

    public function viewAny(User $user)
    {
        return $user->hasModulePermission($this->module_id,'R');
    }

    public function view(User $user,Ebulletin $ebulletin)
    {
        return $user->hasModulePermission($this->module_id,'R');
    }

    public function create(User $user)
    {
        return $user->hasModulePermission($this->module_id,'C');
    }

    public function edit(User $user,Ebulletin $ebulletin)
    {
        return $user->hasModulePermission($this-> module_id,'U');
    }

    public function update(User $user,Ebulletin $ebulletin)
    {
        return $user->hasModulePermission($this-> module_id,'U');
    }

    public function delete(User $user,Ebulletin $ebulletin)
    {
        return $user->hasModulePermission($this->module_id,'D');
    }

    public function restore(User $user,Ebulletin $ebulletin)
    {
        return $user->hasModulePermission($this->module_id,'D');
    }

    public function forceDelete(User $user,Ebulletin $ebulletin)
    {
        return $user->hasModulePermission($this->module_id,'D');
    }
}
