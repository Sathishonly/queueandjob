<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Jobs\SendOtpEmail;

class userController extends Controller
{
    public function login(Request $request)
    {
        $input = $request->all();
        $validation = Validator::make($input, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validation->fails()) {
            return response()->json(['error' => $validation->errors(), 'status_code' => 400], 400);
        } else {
            $user = User::where('email', $request->email)->first();
            if ($user) {

                if (Hash::check($request->password, $user->password)) {
                    $tokenResult = $user->createToken('studio');
                    $accessToken = $tokenResult->accessToken;
                    $otp = mt_rand(100000, 999999);


                    dispatch(new SendOtpEmail($user, $otp));
                    // SendOtpEmail::dispatch($user, $otp);
                    $response = [
                        "status_code" => 200,
                        'token' => $accessToken,
                    ];
                    return response($response, 200);
                } else {
                    return response()->json(['status_code' => 397, "error_code" => "Password mismatch"]);
                }
            } else {
                return response()->json(['status_code' => 396, 'error_code' => "User doesn't exist"]);
            }
        }
    }
}
