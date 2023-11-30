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
use Auth;

class UserController extends Controller
{
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





    public function AdminRoleUpdate(AdminRoleUpdateRequest $request)
    {
        $validatedData = $request->validated();
    
        $validRoles = ['user', 'admin'];
    
        if (!in_array($validatedData['new_role'], $validRoles)) {
            return response()->json(['error' => 'Invalid role provided.'], 400);
        }
    
        $user = auth()->user();
        $user->update(['role' => $validatedData['new_role']]);
    
        return response()->json([
            'message' => 'Admin role updated successfully',
            'user' => $user->fresh(), 
        ]);
    }
    
    public function AllUser(request $request)
    {
        $users = User::OfRole($request->role)->get(); 
    
        return response()->json([
            'message' => 'All users and admin',
            'users' => $users,
        ]);
    }
    

    }

