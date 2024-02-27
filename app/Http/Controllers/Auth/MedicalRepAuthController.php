<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\MedicalRepAuthRequest;
use App\Http\Resources\MedicalRepResource;
use App\Services\MedicalRepAuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MedicalRepAuthController extends Controller
{
    public function __construct(private MedicalRepAuthService $medicalRepAuthService)
    {
    }

    public function login(MedicalRepAuthRequest $request)
    {
        $validatedData = $request->validated();
        $token = $this->medicalRepAuthService->login($validatedData);

        return $this->successResponse(
            $this->resource(Auth::guard('medical_rep')->user(), MedicalRepResource::class),
            'userSuccessfullySignedIn',
            200,
            $token
        );
    }

    public function register(MedicalRepAuthRequest $request)
    {
        $validatedData = $request->validated();
        $token = $this->medicalRepAuthService->register($validatedData);

        return $this->successResponse(
            $this->resource(Auth::guard('medical_rep')->user(), MedicalRepResource::class),
            'userSuccessfullyRegistered',
            200,
            $token
        );
    }

    public function logout(MedicalRepAuthRequest $request)
    {
        $this->medicalRepAuthService->logout();

        return $this->successResponse(
            null,
            'userSuccessfullySignedOut'
        );
    }

    public function check_identity(MedicalRepAuthRequest $request)
    {
        $validatedData = $request->validated();
        $response = $this->medicalRepAuthService->check_identity($validatedData);
        return $this->successResponse(
            $response,
            "requestedSuccessfully"
        );
    }

    public function changePassword(MedicalRepAuthRequest $request)
    {
        $validatedData = $request->validated();
        $this->medicalRepAuthService->changePassword($validatedData);

        return $this->successResponse(
            null,
            'passwordChangedSuccessfully'
        );
    }

    public function saveFcmToken(Request $request)
    {
        $this->medicalRepAuthService->createOrUpdateFcmToken($request);
        return $this->successResponse(
            null,
            'requestedSuccessfully'
        );
    }
}
