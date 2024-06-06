<?php

namespace App\Http\Controllers\Api\V1\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\AdminRoleUpdateRequest;
use Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource;
use App\Http\Filters\V1\UserFilter;
use App\Http\Controllers\Api\V1\ApiController;
use App\Policies\UserPolicy;

class UserController extends ApiController
{
    protected $policyClass = UserPolicy::class;
    public function UserProfileUpdate(UserUpdateRequest $request)
    {
        $user = auth()->user();
        $user->update($request->validated());
        return response()->json(['message' => 'User updated successfully']);
    }


public function userPasswordUpdate(UpdatePasswordRequest $request)
    {
        $validatedData = $request->validated();

        if (!Hash::check($validatedData['old_password'], auth()->user()->password)) {
            return response()->json(['error' => "Old Password Doesn't Match!!"], 400);
        }
   
        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($validatedData['password']),
        ]);

        return response()->json(['status' => 'Password Changed Successfully']);
    }


    

    public function AdminRoleUpdate(Request $request, User $user)
    {
        $this->authorize('isAdmin', User::class);
    
        if ($user->role === 'admin') {
            return response()->json(['message' => 'Cannot change the role of an admin'], 403);
        }
    
        $user->role = 'admin';
        $user->save();
    
        return response()->json(['message' => 'User role updated to admin']);
    }


    public function index(UserFilter $filters)
{

    $this->isAble('ViewUsers', User::class);

    if ($this->include('orders')) {
        return UserResource::collection(User::with('orders')->filter($filters)->paginate());
    }
    return UserResource::collection(User::filter($filters)->paginate());

   
}


}

