<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;



class UserPolicy 
{
    public function isAdmin(User $currentUser)
    {
        return $currentUser->role === 'admin'
        ? Response::allow()
        : Response::deny('You are not permission to preform this action.');
    }
}
