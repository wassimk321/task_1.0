<?php

namespace App\Http\Controllers;

use App\Http\Requests\RatingRequest;
use App\Http\Resources\RatingResource;
use App\Services\RatingService;

class RatingController extends Controller
{
    public function __construct(private RatingService $ratingService)
    {
    }

    public function index()
    {
        $ratings = $this->ratingService->getAll();
        return $this->successResponse(
            $this->resource($ratings, RatingResource::class),
            'dataFetchedSuccessfully'
        );
    }

    public function show($ratingId)
    {
        $rating = $this->ratingService->find($ratingId);

        return $this->successResponse(
            $this->resource($rating, RatingResource::class),
            'dataFetchedSuccessfully'
        );
    }

    public function store(RatingRequest $request)
    {
        //Create a rating for a movie for a given user
        $validatedData = $request->validated();
        $this->ratingService->create($validatedData);

        return $this->successResponse(
             [],
            'dataAddedSuccessfully'
        );
    }

    public function update(RatingRequest $request, $ratingId)
    {
        $validatedData = $request->validated();
        $this->ratingService->update($validatedData, $ratingId);

        return $this->successResponse(
            null,
            'dataUpdatedSuccessfully'
        );
    }

    public function destroy($ratingId)
    {
        $this->ratingService->delete($ratingId);

        return $this->successResponse(
            null,
            'dataDeletedSuccessfully'
        );
    }
}
