<?php

namespace App\Http\Controllers;

use App\Http\Requests\GenreRequest;
use App\Http\Resources\GenreResource;
use App\Services\GenreService;

class GenreController extends Controller
{
    public function __construct(private GenreService $genreService)
    {
    }

    public function index()
    {
        $genres = $this->genreService->getAll();
        return $this->successResponse(
            $this->resource($genres, GenreResource::class),
            'dataFetchedSuccessfully'
        );
    }

    public function show($genreId)
    {
        $genre = $this->genreService->find($genreId);

        return $this->successResponse(
            $this->resource($genre, GenreResource::class),
            'dataFetchedSuccessfully'
        );
    }

    public function store(GenreRequest $request)
    {
        $validatedData = $request->validated();
        $genre = $this->genreService->create($validatedData);

        return $this->successResponse(
            $this->resource($genre, GenreResource::class),
            'dataAddedSuccessfully'
        );
    }

    public function update(GenreRequest $request, $genreId)
    {
        $validatedData = $request->validated();
        $this->genreService->update($validatedData, $genreId);

        return $this->successResponse(
            null,
            'dataUpdatedSuccessfully'
        );
    }

    public function destroy($genreId)
    {
        $this->genreService->delete($genreId);

        return $this->successResponse(
            null,
            'dataDeletedSuccessfully'
        );
    }
}
