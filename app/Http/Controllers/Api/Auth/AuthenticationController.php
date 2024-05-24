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
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Jobs\SendWelcomeEmail; 
use App\Helper\helperfunctions;
use Carbon\Carbon;
use Ichtrojan\Otp\Otp;
use App\Notifications\ResetPasswordNotification;
use App\traits\apiResponse;




class AuthenticationController extends Controller
{
    use apiResponse;
   private $otp;

   public function __construct()
   {
    $this->otp = new Otp();
   }
    public function banUser(Request $request): JsonResponse
    {
        $user = User::find($request->id);
    
        if (!$user) {
        return $this->errorResponse('User not found', 404);
        }
    
        if ($user->isBanned()) {
            return $this->errorResponse('User is already banned', 400);
        }

        $user->ban([
            'comment' => 'Enjoy your ban!',
            'expired_at' => Carbon::now()->addMonth(), 
        ]);
    
        return $this->successResponse('User banned successfully', 200);
       
    }
    
    public function unbanUser(Request $request): JsonResponse
    {
        $user = User::find($request->id);
    
        if (!$user) {
            return $this->errorResponse('User not found', 404);
  
        }
    
        if ($user->isNotBanned()) {
            return $this->errorResponse('User is not currently banned', 400);
        }

        $user->unban();
         return $this->successResponse('User unbanned successfully', 200);

    }
    public function createUser(StoreUser $request): JsonResponse
    {
        try {
            $validatedData = $request->validated(); 
            
            // Check if the user's email is banned
            $user = User::where('email', $validatedData['email'])->first();
            if ($user && $user->isBanned()) {

             return $this->errorResponse('User is banned. Cannot create account.', 403);
               
            }
            
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'phone' => $validatedData['phone'],
                'address' => $validatedData['address'],
            ]);
    
            // fetch the user ip and address and save it to the database
            // helperfunctions::saveIPInformation($request);
            dispatch((new SendWelcomeEmail($user))->delay(now()->addMinutes(1)));
            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
                'token' => $user->createToken('API TOKEN')->plainTextToken,
                'user' => $user,
            ], 200);
        } catch (\Throwable $th) {
          return $this->errorResponse($th->getMessage(), 500);
        }
    }

    public function loginUser(LoginUser $request): JsonResponse
    {
        try {
            $validatedData = $request->validated();

            $user = User::where('email', $validatedData['email'])->first();
            if ($user && $user->isBanned()) {

                return $this->errorResponse('User is banned. Cannot login.', 403);
    
            }
    
            if (!Auth::attempt($request->only(['email', 'password']))) {

                return $this->errorResponse('Email & Password do not match our records.', 401);
               
            }
    
            $user = Auth::user();
    
            return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
                'token' => $user->createToken('API TOKEN')->plainTextToken,
                'user' => $user,
            ], 200);
        } catch (\Throwable $th) {
           return $this->errorResponse($th->getMessage(), 500);
        }
    }

    public function forgotPassword(Request $request)
    {
    $request->validate(['email' =>'required|email|exists:users,email']);
    $input  = $request->only('email');
    $user = User::where('email', $input)->first();
        $user->notify(new ResetPasswordNotification());
        return $this->successResponse('We have e-mailed your password reset link!', 200);
    }

    public function resetPassword(ResetPass $request)
    {
   
       $otp2 =  $this->otp->validate($request->email,$request->otp);
       if ( ! $otp2->status) {
        return $this->errorResponse('Invalid OTP', 401);
       }

       $user = User::where('email', $request->email)->first();
       $user->update(['password' => Hash::make($request->password)]);
       $user->tokens()->delete();
       return $this->successResponse('Password Reset Successfully', 200);
     
    }

    public function logout(Request $request, $userId): JsonResponse
    {
        if (!Auth::check()) {
            return $this->errorResponse('User not authenticated', 401);
        }
    
        $user = User::find($userId);
        if (!$user) {
            return $this->errorResponse('User not found', 404);
        }
    
        return $user->tokens()->delete()
            ? $this->successResponse('Logout Successful', 200)
            : $this->errorResponse('Logout Failed', 500);
    }
    
}





   
