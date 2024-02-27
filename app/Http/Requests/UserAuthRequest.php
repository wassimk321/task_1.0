<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserAuthRequest extends FormRequest
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
        return match ($this->getFunctionName()) {

            'login'           => $this->login(),
            'generateOTP'     => $this->generateOTP(),
            'changePassword'  => $this->changePassword(),
            'verifyOTP'       => $this->generateOTP(),
            'verifyNewPhone'  => $this->verifyNewPhoneOTP(),
            default           => $this->generateOTP(),
        };
    }

    public function login()
    {
        return [
            'email'    => 'sometimes|email',
            'phone'    => 'sometimes|numeric',
            'password' => 'required|string|min:6|max:30'
        ];
    }
    public function generateOTP()
    {
        return [
            'phone'    => 'required|numeric|exists:users,phone',
            'code'     => 'sometimes|numeric',
        ];
    }
    public function verifyNewPhoneOTP()
    {
        return [
            'phone'    => 'required|numeric|unique:users,phone',
            'code'     => 'sometimes|numeric',
        ];
    }
    public function changePassword()
    {
        return [
            'old_password'    => 'required|numeric|current_password:user',
            'password'        => 'sometimes|string|confirmed|min:6|max:30',
        ];
    }


    public function getFunctionName(): string
    {
        $action = $this->route()->getAction();
        $controllerAction = $action['controller'];
        list($controller, $method) = explode('@', $controllerAction);
        return $method;
    }
}
