<?php
namespace App\Permissions\V1;

use App\Models\User;

final class Abilities
{
    public const ViewReviews = 'view:Any';  // Allows viewing all reviews
    public const CreateReview = 'create:review';
    public const ViewOwnReview = 'view:own:review';
    public const Allusers = 'view:users';

    public static function getAbilities(User $user)
    {
        if ($user->isAdmin()) {
            return [
                self::ViewReviews, 
                self::Allusers,
            ];
        } else {
            return [
                self::CreateReview,
                self::ViewOwnReview,  // Non-admins can create and view their own reviews
            ];
        }
    }
}
