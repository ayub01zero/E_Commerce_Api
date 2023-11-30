<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUser;
use App\Http\Requests\ResetPass;
use App\Http\Requests\StoreUser;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Password;
use Str;
use Validator;

class AuthenticationController extends Controller
{
    
public function createUser(StoreUser $request): JsonResponse
{
    try {
        $request->validated($request->safe()->only([
            'name','email', 'password','phone','address'
        ]));
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'address' => $request->address,
                
            ]);

            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
                'token' => $user->createToken('API TOKEN')->plainTextToken,
                'user' => $user,
            ], 200);
        

    } catch (\Throwable $th) {
        return response()->json([
            'status' => false,
            'message' => $th->getMessage(),
        ], 500);
    }
}


public function loginUser(LoginUser $request): JsonResponse
{
        try {
                 $request->validated();
    
                if (!Auth::attempt($request->safe()->only(['email', 'password']))) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Email & Password do not match our records.',
                    ], 401); 
                }
        
                $user = Auth::user(); 
        
                return response()->json([
                    'status' => true,
                    'message' => 'User Logged In Successfully',
                    'token' => $user->createToken('API TOKEN')->plainTextToken,
                ], 200);

            
    
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
}


    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $response = Password::sendResetLink(
            $request->only('email')
        );
// mean the email send or not 
        return $response === Password::RESET_LINK_SENT
            ? response()->json(['message' => 'Reset link sent to your email.', 'status' => true], 200)
            : response()->json(['message' => 'Unable to send reset link.', 'status' => false], 400);
    }

    public function resetPassword(ResetPass $request)
    {

        $request->validated();
        $response = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' =>Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        return $response === Password::PASSWORD_RESET
            ? response()->json(['message' => 'Password reset successfully.', 'status' => true], 200)
            : response()->json(['message' => 'Unable to reset password.', 'status' => false], 400);
    }




    public function logout(): JsonResponse
    {
        if (Auth::check()) {
            Auth::user()->currentAccessToken()->delete();
            return response()->json([
                'status' => true,
                'message' => 'User Logout Successfully',
            ], 201);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'User not authenticated',
            ], 401);
        }
    }
    


}





   
