<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\{LoginUser,ResetPass,StoreUser};
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserDetails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Password;
use Str;
use App\Jobs\SendWelcomeEmail; 
use Validator;


class AuthenticationController extends Controller
{
    
    public function createUser(StoreUser $request): JsonResponse
    {
        try {
            $validatedData = $request->validated(); 
            
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'phone' => $validatedData['phone'],
                'address' => $validatedData['address'],
            ]);

            $ipInformation = new UserDetails([
                'user_id' => $user->id,
                'ip' => $request->ipinfo->ip,
                'city' => $request->ipinfo->city,
                'region' => $request->ipinfo->region,
                'location' => $request->ipinfo->loc,
                'postal' => $request->ipinfo->postal,
            ]);
            
            $ipInformation->save();
            
            dispatch(new SendWelcomeEmail($user))->delay(now()->addMinutes(1));
    
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




    public function logout(Request $request, $userId): JsonResponse
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }
    
        $user = User::find($userId);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
    
        return $user->tokens()->delete()
            ? response()->json(['message' => 'User logged out successfully'], 200)
            : response()->json(['message' => 'Logout Failed'], 200);
    }
    


    


}





   
