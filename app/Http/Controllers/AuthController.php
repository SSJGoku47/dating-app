<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\SocialLogin;
use App\Models\UserProfile;
use App\Models\UserVerify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{   
    public function register(Request $request)
    {   
        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users,email', 
                'password' => 'required|min:8',
                'confirm_password' => 'required|same:password',
            ]);
            
            // Create a new user
            $registerUser = new User();
            $registerUser->name = $request->name;
            $registerUser->email = $request->email;
            $registerUser->is_admin = true;
            $registerUser->role_id = $this->getAdminRoleId() ?? "Admin";
            $registerUser->password = bcrypt($request->password);
            $registerUser->save();

            session()->flash('success', 'User registered successfully');

            return redirect()->route('login');

        } catch (\Throwable $e) {
            session()->flash('error', $e->getMessage());
            return redirect()->route('register')->withInput();
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);
        $credentials = $request->only('email', 'password');
        try {
            // Attempt to authenticate the user
            if (Auth::guard('web')->attempt($credentials)) {
                // Create an access token for the authenticated user
                $token = auth()->user()->createToken('authToken')->accessToken; 
                session()->flash('success', 'Login successfull!');
                $response = [
                    'success' => true,
                    'token' => $token
                ];
                
                return redirect()->route('dashboard');
            } else {
                session()->flash('error', 'Invalid credentials. Please try again.');
                return redirect()->route('login')->withInput();
            }
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
            \Log::error('Login error: ' . $e->getMessage());
            return redirect()->route('login')->withInput();
        }
    }
    public function resetPassword(Request $request)
    {   
        try {
            // Validate the incoming request
            $request->validate([
                'email' => 'required|email|exists:users,email',
                'password' => 'required|min:8|',
                'confirm_password' => 'required|same:password',
            ]);
            // Find the user by email
            $user = User::where('email', $request->email)->first();
            if ($user) {
                $user->password = Hash::make($request->password);
                $user->save();
                session()->flash('success', 'Passwerd Updated successfully!');
                return redirect()->route('login');
            }
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
            return redirect()->route('password.reset')->withInput();
        }
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        Auth::guard('web')->logout();
        session()->flash('success', 'You have been logged out successfully.');
        return redirect()->route('login');
    }

    public function mobileLogout()
    {   
        try {
            auth()->user()->tokens()->delete();
            return response()->json(['status' => 'success','error' =>'You have been logged out']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error','message' => $th->getMessage()], 500);
        }
    }

    public function mobileLogin(Request $request)
    {   
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('MobileAppToken')->accessToken;

            return response()->json(['status' => 'success', 'message' => 'Login successfull','token' => $token], 200);
        } else {
            return response()->json(['success' => false,'message' => 'Invalid credentials',], 401);
        }
    }

    /**
     * Redirect to the provider's login page.
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->stateless()->redirect();
    }

    public function handleProviderCallback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->stateless()->user();

            // Find or create user
            $user = User::where('email', $socialUser->getEmail())->first();

            if (!$user) {
                $user = User::create([
                    'name' => $socialUser->getName(),
                    'email' => $socialUser->getEmail(),
                ]);
            }
            // Link or update social login record
            $socialLogin = SocialLogin::updateOrCreate(
                [
                    'provider' => $provider,
                    'provider_id' => $socialUser->getId(),
                ],
                [
                    'user_id' => $user->id,
                ]
            );
            // Generate token for API
            $token = $user->createToken('SocialLoginToken')->accessToken;
            return response()->json(['status' => 'success','message' => 'Login successful','token' => $token,], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error','message' => 'Unable to login','error' => $e->getMessage(),], 500);
        }
    }

    public function mobileRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false,'errors' => $validator->errors(),], 400);
        }

        DB::beginTransaction();  

        try {
            // Register the user
            $registerUser = new User();
            $registerUser->name = $request->name;
            $registerUser->email = $request->email;
            $registerUser->role_id = $this->getUserRoleId() ?? "User";
            $registerUser->is_active = true;
            $registerUser->password = bcrypt($request->password);
            $registerUser->save();
    
            // Create the user profile
            $this->createUserprofile($registerUser->id);
    
            DB::commit();  
    
            return response()->json(['status' => 'success', 'message' => 'Registration successful.'], 201);
        } catch (\Exception $e) {
            DB::rollBack();  
            return response()->json(['status' => 'error', 'message' => 'Registration failed.', 'error' => $e->getMessage()], 500);
        }
    }

    public function sendOtp(Request $request)
    {
        $otp = rand(100000, 999999);
        $email = $request->email;
        // Send OTP to user
        $user = User::where('email',  $email)->first();

        $userVerify = new UserVerify();
        $userVerify->user_id = $user->id;
        $userVerify->otp = $otp;
        $userVerify->is_used = false;
        $userVerify->save();
        
        if($user) {
            // Send email
            Mail::send('email.otp', ['otp' => $otp], function($message) use ($email) {
                $message->to($email)
                        ->subject('Your OTP Verification Code');
            });
            return response()->json(['status' => 'success','message' => 'OTP sent successfully']);
        }
        return response()->json(['status' => 'error','message' => 'User Email not found'], 404);
    }
    
    public function verifyOtp(Request $request)
    {   
        try {
            $request->validate([
                'email' => 'required|email|exists:users,email',
                'otp' => 'required|integer',
            ]);
        
            $user = User::where('email', $request->email)->first();
            if (!$user) {
                return response()->json(['status' => 'error', 'message' => 'User Email not found'], 404);
            }
            $userVerify = $user->userVerify;
            if (!$userVerify) {
                return response()->json(['status' => 'error', 'message' => 'No OTP found for this user'], 404);
            }
            if ($userVerify->is_used == true) {
                return response()->json(['status' => 'error', 'message' => 'OTP has already been used'], 400);
            }
            if ($userVerify->otp == $request->otp) {
                // Mark the OTP as used
                $userVerify->is_used = true;
                $userVerify->save();
                return response()->json(['status' => 'success', 'message' => 'OTP verified successfully'],200);
            }
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], 400);
        }
    }
    

    public function mobilePasswordReset(Request $request)
    {   
        try {
            // Validate the incoming request
            $request->validate([
                'password' => 'required|min:8|confirmed',
            ]);
            // Find the user by email
            $user = User::where('email', $request->email)->first();
            if ($user) {
                $user->password = Hash::make($request->password);
                $user->save();
                return response()->json(['status' => 'success','message' => 'Password reset successfully']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error','message' => 'Password reset Failed'], 200);
        }   
    }

    protected function getUserRoleId(){
        $getUserRoleId = Role::where('name', "User")->first();
        return $getUserRoleId? $getUserRoleId->id : null;
    }

    protected function getAdminRoleId(){
        $getAdminRoleId = Role::where('name', "Admin")->first();
        return $getAdminRoleId? $getAdminRoleId->id : null;
    }

    protected function createUserprofile($user_id){
        
        $userProfile = new UserProfile();
        $userProfile->user_id =$user_id;
        $userProfile->gender_id = null;
        $userProfile->match_gender_preference_id = null;
        $userProfile->ethnicity_id = null;
        $userProfile->education_qualifications_id = null;
        $userProfile->about = '';
        $userProfile->occupation = '';
        $userProfile->age = 0;
        $userProfile->height = 0;
        $userProfile->save();
    }
}
