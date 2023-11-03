<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Exception;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;




class GoogleController extends Controller
{
    public function googlepage()
    {
        return Socialite::driver('google')->redirect();
    }

    public function Callback()
    {
        try {
            
            $user = Socialite::driver('google')->user();

            $findUser = User::where('google_id', $user->id)->first(); // Updated variable name
            if ($findUser) {
                Auth::login($findUser);
                $token = $findUser->createToken('API TOKEN')->plainTextToken;
                $response=response()->json([
                    "token" => $token,
                    "user_id" => $user->id,
                    "role_id" => $user->role_id,
                    'status' => 'success',
                    'message' => 'User Login successfully'
                ], 201);
                $redirectUrl = 'http://localhost:4200/home?'.http_build_query($response);
                return Redirect::away($redirectUrl);
                        } else {
                $googleUser = new User([
                    'first_name' => $user['given_name'],
                    'last_name' => $user['family_name'],
                    'email' => $user->email,
                    'google_id' => $user->id,
                    'password' => encrypt('123456dummy'),
                    'role_id' => 1
                ]);
                $googleUser->save();

                $token = $googleUser->createToken('API TOKEN')->plainTextToken;
                $response=response()->json([
                    "token" => $token,
                    "user_id" => $user->id,
                    "role_id" => $user->role_id,
                    'status' => 'success',
                    'message' => 'User Login successfully'
                ], 201);
                Session::put('response', $response);
                return Redirect::away('http://localhost:4200/home');
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}