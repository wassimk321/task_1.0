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
        // get all the movies in json format
        // using GET request /api/movies
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
    public function movieRatings($movieId)
    {
        //Determine the rating of a movie by using all ratings of all users.
        $averageRating = $this->movieService->movieRatings($movieId);
        $data = ['avg_rating' => $averageRating];
        return $this->successResponse(
            $data,
            'dataFetchedSuccessfully'
        );
    }
}
