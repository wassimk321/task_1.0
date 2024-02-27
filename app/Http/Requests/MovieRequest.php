<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MovieRequest extends FormRequest
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
            'title' => 'required|string',
            'year' => 'required|integer',
            'genre_id' => 'required|exists:genres,id',

          ];
    }

    public function getUpdateRules()
    {
          return [
            'title' => 'sometimes|string',
            'year' => 'sometimes|integer',
            'genre_id' => 'sometimes|exists:genres,id',

          ];
    }
}
