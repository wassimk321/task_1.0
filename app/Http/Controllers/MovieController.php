<?php

namespace App\Http\Controllers;

use App\Http\Requests\MovieRequest;
use App\Http\Resources\MovieResource;
use App\Services\MovieService;

class MovieController extends Controller
{
    public function __construct(private MovieService $movieService)
    {
    }

    public function index()
    {
        $movies = $this->movieService->getAll();
        return $this->successResponse(
            $this->resource($movies, MovieResource::class),
            'dataFetchedSuccessfully'
        );
    }

    public function show($movieId)
    {
        $movie = $this->movieService->find($movieId);

        return $this->successResponse(
            $this->resource($movie, MovieResource::class),
            'dataFetchedSuccessfully'
        );
    }

    public function store(MovieRequest $request)
    {
        $validatedData = $request->validated();
        $movie = $this->movieService->create($validatedData);

        return $this->successResponse(
            $this->resource($movie, MovieResource::class),
            'dataAddedSuccessfully'
        );
    }

    public function update(MovieRequest $request, $movieId)
    {
        $validatedData = $request->validated();
        $this->movieService->update($validatedData, $movieId);

        return $this->successResponse(
            null,
            'dataUpdatedSuccessfully'
        );
    }

    public function destroy($movieId)
    {
        $this->movieService->delete($movieId);

        return $this->successResponse(
            null,
            'dataDeletedSuccessfully'
        );
    }
}