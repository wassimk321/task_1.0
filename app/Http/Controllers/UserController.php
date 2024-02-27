<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\MedicalRepResource;
use App\Http\Resources\UserResource;
use App\Models\MedicalRep;
use App\Services\UserService;

class UserController extends Controller
{
    public function __construct(private UserService $userService)
    {
    }

    public function index()
    {
        $users = $this->userService->getAll();
        return $this->successResponse(
            $this->resource($users, UserResource::class),
            'dataFetchedSuccessfully'
        );
    }

    public function show($userId)
    {
        $user = $this->userService->find($userId);

        return $this->successResponse(
            $this->resource($user, UserResource::class),
            'dataFetchedSuccessfully'
        );
    }

    public function store(UserRequest $request)
    {
        $validatedData = $request->validated();
        $user = $this->userService->create($validatedData);

        return $this->successResponse(
            $this->resource($user, UserResource::class),
            'dataAddedSuccessfully'
        );
    }

    public function update(UserRequest $request, $userId)
    {
        $validatedData = $request->validated();
        $this->userService->update($validatedData, $userId);

        return $this->successResponse(
            null,
            'dataUpdatedSuccessfully'
        );
    }

    public function destroy($userId)
    {
        $this->userService->delete($userId);

        return $this->successResponse(
            null,
            'dataDeletedSuccessfully'
        );
    }
}
