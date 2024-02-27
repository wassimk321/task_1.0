<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
             default => $this->getUpdateRules()
        };
    }

    public function getCreateRules()
    {
        $rules = [
            'first_name'          => 'required|string|max:255',
            'last_name'           => 'required|string|max:255',
            'email'               => 'sometimes|required|email|unique:users,email',
            'password'            => 'required|confirmed|min:8',
            'phone'               => 'required|numeric|unique:users,phone',
        ];


        return $rules;
    }

    public function getUpdateRules()
    {
        $user_id = $this->route('user');
        $rules = [
            'first_name'          => 'sometimes|required|string|max:255',
            'last_name'           => 'sometimes|required|string|max:255',
            'email'               => ['sometimes', 'required', 'email', Rule::unique('users', 'email')->ignore($user_id)],
            'password'            => 'sometimes|required|min:8',
            'phone'               => ['sometimes', 'required', Rule::unique('users', 'phone')->ignore($user_id)],

        ];

        return $rules;
    }

}
