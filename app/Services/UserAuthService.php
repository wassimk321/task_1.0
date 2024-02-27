<?php

namespace App\Services;

use App\Models\OTP;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Traits\ModelHelper;
use Exception;

class UserAuthService
{
    use ModelHelper;

    public function login($validatedData)
    {

        if (array_key_exists('phone', $validatedData)) {
            $user = User::where('phone', $validatedData['phone'])->first();
        }
        if (array_key_exists('email', $validatedData)) {
            $user = User::where('email', $validatedData['email'])->first();
        }

        // dd($user);
        if (!$user) {
            throw new Exception(__('messages.credentialsError'), 401);
        }
        $attemptedData = [
            'phone'    => $user->phone,
            'password' => $validatedData['password']
        ];

        if (!$token = Auth::guard('user')->attempt($attemptedData)) {
            throw new Exception(__('messages.incorrect_password'), 401);
        }
        return [
            'user'  => $user,
            'token' => $token
        ];
    }

    public function changePassword($validatedData)
    {

        $user = User::find(auth('user')->user()->id);

        DB::beginTransaction();

        $user->update(['password' => Hash::make($validatedData['password'])]);

        DB::commit();

        return true ;
    }

    public function logout()
    {
        Auth::guard('user')->logout();
    }
    public function generateOTP($validatedData)
    {
        $code = rand(111111, 999999);
        $otp = OTP::updateOrCreate(
            ["phone" => $validatedData['phone']],
            ["code" => $code]
        );
        return $otp;
    }
    public function verifyOTP($validatedData)
    {

        $otp = OTP::where('code', $validatedData['code'])->where('phone', $validatedData['phone'])->first();

        if (!$otp) {
            throw new Exception(__('messages.something went wrong'), 401);
        }
        $otp->delete();
        return true;
    }
}
