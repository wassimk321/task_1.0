<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Traits\ModelHelper;
use App\Models\Genre;

class GenreService
{
    use ModelHelper;

    public function getAll()
    {
        return Genre::all();
    }

    public function find($genreId)
    {
        return Genre::findOrFail($genreId);
    }

    public function create($validatedData)
    {
        DB::beginTransaction();

        $genre = Genre::create($validatedData);

        DB::commit();

        return $genre;
    }

    public function update($validatedData, $genreId)
    {
        $genre = Genre::findOrFail($genreId);

        DB::beginTransaction();

        $genre->update($validatedData);

        DB::commit();

        return true;
    }

    public function delete($genreId)
    {
        $genre = $this->find($genreId);

        DB::beginTransaction();

        $genre->delete();

        DB::commit();

        return true;
    }
}
