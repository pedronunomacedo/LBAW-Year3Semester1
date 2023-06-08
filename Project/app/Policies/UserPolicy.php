<?php

namespace App\Policies;

use App\Models\User;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class UserPolicy {
    use HandlesAuthorization;

    public function show(User $user, $user2) {
      // Only an authenticated user can see it
      return $user->id == $user2->id;
    }

    public function edit(User $user, $user2) {
      // Only an authenticated user can see it
      return $user->id == $user2->id;
    }

    public function editProfile(User $user, User $user2) {
      return $user->id == $user2->id;
    }

    public function admin(User $user, User $user2) {
      // Only an authenticated user can see all users

      return $user->id == $user2->id && $user2->isAdmin();
    }
}
