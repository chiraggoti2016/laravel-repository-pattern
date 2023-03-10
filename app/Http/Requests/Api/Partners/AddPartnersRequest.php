<?php

namespace App\Http\Requests\Api\Partners;

use Illuminate\Foundation\Http\FormRequest;

class AddPartnersRequest extends FormRequest
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
        return [
            'name'      => 'required',
            'address'   => 'required',
            'country'   => 'required',
            'users'     => 'required|array',
        ];
    }
}
