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
use Illuminate\Support\Facades\Validator;
class ChangePasswordController extends Controller
{
    public function changepass(Request $request, User $user){
    try {
        $token = PasswordReset::where('token', $request->token)->first();
        if ($token) {
            $email=$token->email;
            if($email == $request->email){
                $user = User::where('email', $request->email)->first();
                $validator = Validator::make($request->all(), [
                    "email"=>"required",
                    "password"=>"required",
                ]);
                $update=$user->update($request->all());
                if($update){
                    $token->delete();
                }
            }else{
                return response()->json(['success' => false, 'msg' => 'Wrong email']);
            }

            return response()->json(['success' => true, 'msg' => 'Password Changed successfully']);
        } else {
            return response()->json(['success' => false, 'msg' => 'Wrong Code']);
        }
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'msg' => $e->getMessage()]);
    }

}  
}
