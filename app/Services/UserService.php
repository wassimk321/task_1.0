<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Traits\ModelHelper;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    use ModelHelper;



    public function getAll()
    {
        if (request()->has('role'))
            return User::where('role', '=', request()->get('role'))->get();
        return User::all();
    }

    public function find($userId)
    {
        return $this->findByIdOrFail(User::class,'user', $userId);
    }

    public function create($validatedData)
    {

        DB::beginTransaction();

        $validatedData['password'] = Hash::make($validatedData['password']);
        $user = User::create($validatedData);

        DB::commit();

        return $user;
    }

    public function update($validatedData, $userId)
    {
        $user = $this->find($userId);

        DB::beginTransaction();
        if(array_key_exists('password',$validatedData)){
            $validatedData['password'] = Hash::make($validatedData['password']);
        }

        $user->update($validatedData);

        DB::commit();

        return true;
    }

    public function delete($userId)
    {
        $user = $this->find($userId);

        DB::beginTransaction();

        $user->delete();

        DB::commit();

        return true;
    }
    public function getUsersByIds($ids)
    {
        return User::whereIn('id',$ids)->get();
    }

}
