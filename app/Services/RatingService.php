<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Traits\ModelHelper;
use App\Models\Rating;

class RatingService
{
    use ModelHelper;

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

        $rating = Rating::create($validatedData);

        DB::commit();

        return $rating;
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
