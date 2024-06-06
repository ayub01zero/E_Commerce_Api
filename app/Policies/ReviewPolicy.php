<?php

namespace App\Policies;

use App\Models\Review;
use App\Models\User;
use App\Permissions\V1\Abilities;
use Illuminate\Auth\Access\Response;

class ReviewPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
      if($user->tokenCan(Abilities::ViewReviews))
      {
          return true;
      }
          return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Review $review): bool
    {
        if ($user->tokenCan(Abilities::ViewReviews)) {
            return true;
        } else if ($user->tokenCan(Abilities::ViewOwnReview)) {
            return $user->id === $review->user_id;
        }
    
        return false;
    }
    

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if($user->tokenCan(Abilities::CreateReview))
        {
            return $user->role == 'user';
        }
        return false;
    }

   
}

