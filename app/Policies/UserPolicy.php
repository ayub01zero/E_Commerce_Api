<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use App\Permissions\V1\Abilities;



class UserPolicy 
{
    public function ViewUsers(User $currentUser): bool
    {
        if($currentUser->tokenCan(Abilities::Allusers))
        {
           return true;
        }
        return false;
    }

}
