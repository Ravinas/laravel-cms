<?php

namespace CMS\Policies;

use CMS\Models\Form;
use CMS\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FormPolicy
{
    use HandlesAuthorization;

    public function cru(User $user){
        return $user->hasModulePermission(FORM,'C');
    }
    public function del(User $user){
        return $user->hasModulePermission(FORM,'D');
    }

    public function viewAny(User $user) { return $this->cru($user); }

    public function view(User $user ) { return $this->cru($user); }

    public function create(User $user) { return $this->cru($user); }

    public function edit(User $user ) { return $this->cru($user); }

    public function update(User $user ) { return $this->cru($user); }

    public function delete(User $user ) { return $this->del($user); }

    public function restore(User $user ) { return $this->del($user); }

    public function forceDelete(User $user ) { return $this->del($user); }
}
