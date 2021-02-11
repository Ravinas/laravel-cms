<?php

namespace CMS\Policies;

use CMS\Models\Category;
use CMS\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization;

    public function cru(User $user){
        return $user->hasModulePermission(CONTENT,'C');
    }
    public function del(User $user){
        return $user->hasModulePermission(CONTENT,'D');
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
