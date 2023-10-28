<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\UserPhone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email" => "required|email|min:5|max:50|unique:users,email",
            "password" => ["required", "min:2", "max:50", "confirmed", "regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/"],
            "first_name" => "required|min:2|max:15",
            "last_name" => "required|min:2|max:15",
            "phone1" => ["required", "regex:/^(\+20-1)[0-9]{9}$/"],
            "phone2" => ["required", "regex:/^(\+20-1)[0-9]{9}$/"]
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => $validator->errors()->all()
            ], 422);
        }

        $user = new User([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 1
        ]);

        $user->save();

        $this->storeUserPhone($request->phone1, $user->id);
        $this->storeUserPhone($request->phone2, $user->id);


        $token = $user->createToken('API TOKEN')->plainTextToken;

        $user->update(['remember_token' => $token]);

        return response()->json([
            "token" => $token,
            "user_id" => $user->id,
            "role_id" => $user->role_id,
            'status' => 'success',
            'message' => 'User registered successfully'
        ], 201);
    }

    public function storeUserPhone($phone, $user_id)
    {
        $user_phone = new UserPhone([
            'phone' => $phone,
            'user_id' => $user_id
        ]);

        $user_phone->save();
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email" => "required|email|min:5|max:50",
            "password" => ["required", "min:2", "max:50"],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => $validator->errors()->all()
            ], 422);
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Invalid email or password'
            ], 401);
        }

        $user = User::where('email', $request->email)->first();
        if($user->role_id==2){
            return response()->json([
                'status' => 'failed',
                'message' => 'your r not user'
            ], 401);
        }

        $token = $user->createToken('API TOKEN')->plainTextToken;
        // $user->update(['remember_token' => $token]);

        return response()->json([
            "token" => $token,
            "user_id" => $user->id,
            "role_id" => $user->role_id,
            'status' => 'success',
            'message' => 'User registered successfully'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function logout($token = null)
    {
        // $user = User::where('remember_token', $request->token)->first();
        // if ($user) {
        //     $user->update(['remember_token' => null]);
        //     return response()->json([
        //         'status' => 'success',
        //         'message' => 'User logged out successfully'
        //     ], 200);
        // }

        // return response()->json([
        //     'status' => 'failed',
        //     'message' => 'User is not logged in'
        // ], 400);
        $user = Auth::guard('sanctum')->user();
        if(null===$token)
        {
            $user->currentAccessToken()->delete() ;
            return ;
        }
        $personalAccessToken = PersonalAccessToken::findToken($token);

        if ($user->id == $personalAccessToken->tokenable_id && 
        get_class($user) == $personalAccessToken->tokenable_type) {
            $personalAccessToken->delete();
        }
    }
}
