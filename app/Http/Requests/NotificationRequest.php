<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NotificationRequest extends FormRequest
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
             default   =>  $this->getCreateRules(),
        };
    }

    public function getCreateRules()
    {
          return [
            'type'            => '',
            'notifiable_type' => '',
            'notifiable_id'   => '',
            'data'            => '',
            'user_ids'        => '',
          ];
    }

    public function getUpdateRules()
    {
          return [
            'type' => '',
            'notifiable_type' => '',
            'notifiable_id' => '',
            'data' => ''
          ];
    }
}
