<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Traits\ModelHelper;
use App\Models\Rating;
use Illuminate\Support\Facades\Auth;

class RatingService
{
    use ModelHelper;

    public function __construct(private readonly MovieService $movieService)
    {

    }
    public function getAll()
    {
        return Rating::all();
    }

    public function find($ratingId)
    {
        return Rating::findOrFail($ratingId);
    }

    public function create($validatedData)
    {
        DB::beginTransaction();

        //Get the authenticated user
        $user = Auth::user();
        // Get the desired movie
        $movie = $this->movieService->find($validatedData['movie_id']);
        // Check if the user has already rated the movie
        $existingRating = $movie->ratings()->where('user_id', $user->id)->first();
        if ($existingRating) {
            // Update the existing rating
            $existingRating->update([
                'rating' => $validatedData['rating'],
            ]);
        } else {
            // Create a new rating
            $movie->ratings()->create([
                'user_id' => $user->id,
                'rating' => $validatedData['rating'],
            ]);
        }

        DB::commit();

        return true;
    }

    public function update($validatedData, $ratingId)
    {
        $rating = Rating::findOrFail($ratingId);

        DB::beginTransaction();

        $rating->update($validatedData);

        DB::commit();

        return true;
    }

    public function delete($ratingId)
    {
        $rating = $this->find($ratingId);

        DB::beginTransaction();

        $rating->delete();

        DB::commit();

        return true;
    }
}
