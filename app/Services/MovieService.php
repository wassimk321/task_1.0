<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Traits\ModelHelper;
use App\Models\Movie;

class MovieService
{
    use ModelHelper;

    public function getAll()
    {
        return Movie::all();
    }

    public function find($movieId)
    {
        return Movie::findOrFail($movieId);
    }

    public function create($validatedData)
    {
        DB::beginTransaction();

        $movie = Movie::create($validatedData);

        DB::commit();

        return $movie;
    }

    public function update($validatedData, $movieId)
    {
        $movie = Movie::findOrFail($movieId);

        DB::beginTransaction();

        $movie->update($validatedData);

        DB::commit();

        return true;
    }

    public function delete($movieId)
    {
        $movie = $this->find($movieId);

        DB::beginTransaction();

        $movie->delete();

        DB::commit();

        return true;
    }

    public function movieRatings($movieId)
    {
        $movie = Movie::findOrFail($movieId);
        $averageRating = $movie->getAverageRating();
        return $averageRating;
    }

}
