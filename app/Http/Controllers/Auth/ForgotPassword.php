<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\MedicalRepAuthRequest;
use App\Services\MedicalRepAuthService;

class ForgotPassword extends Controller
{

    public function __construct(private MedicalRepAuthService $medicalRepAuthService)
    {
    }

    public function reset_password_request(MedicalRepAuthRequest $request)
    {
        $validatedData = $request->validated();
        $response = $this->medicalRepAuthService->reset_password_request($validatedData);
        return $this->successResponse(
            $response,
            "requestedSuccessfully"
        );
    }

    public function otp_verification_submit(MedicalRepAuthRequest $request)
    {
        $validatedData = $request->validated();
        $response = $this->medicalRepAuthService->otp_verification_submit($validatedData);
        return $this->successResponse(
            $response,
           'VerificationCompletedSuccessfully'
        );
    }


    public function reset_password_submit(MedicalRepAuthRequest $request)
    {
        $validatedData = $request->validated();
        $this->medicalRepAuthService->reset_password_submit($validatedData);
        return $this->successResponse(
            null,
            'passwordChangedSuccessfully'
        );
    }
}
