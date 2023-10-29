<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\PasswordReset;
use Carbon\Carbon;

class ResetPasswordController extends Controller
{
    public function forgetPass(Request $request)
    {
        try {
            $user = User::where('email', $request->email)->first();

            if ($user) {
                $token =Str::random(8);
                $data['url'] =  $token;
                $data['email'] = $request->email;
                $data['title'] = "Password Reset";
                $data['body'] = "Please click on the below link to reset your password.";

                Mail::send('ForgetPasswordMail', ['data' => $data], function ($message) use ($data) {
                    $message->to($data['email'])->subject($data['title']);
                });
                $date_time = Carbon::now()->format('Y-m-d H:i:s');
                $Insert=PasswordReset::Create(
                    ['email' => $request->email,
                    'token' => $token,
                    'created_at' => $date_time,],
                );

                return response()->json(['success' => true, 'msg' => 'Password reset email sent.']);
            } else {
                return response()->json(['success' => false, 'msg' => 'User not found.']);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }
}