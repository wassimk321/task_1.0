<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RatingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

         return match ($this->route()->getActionMethod()) {
            'store'   =>  $this->getCreateRules(),
            'update'   =>  $this->getUpdateRules(),
        };
    }

    public function getCreateRules()
    {
          return [
            'user_id' => 'required|',
            'movie_id' => 'required|',
            'rating' => 'required|integer',

          ];
    }

    public function getUpdateRules()
    {
          return [
            'user_id' => 'required|',
            'movie_id' => 'required|',
            'rating' => 'required|integer',

          ];
    }
}
