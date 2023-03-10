<?php

namespace App\Http\Requests\Api\Customers;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomersRequest extends FormRequest
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
            'id'        => 'required',
            'name'      => 'required',
            'address'   => 'required',
            'country'   => 'required',
            'users'     => 'required|array',
            'projects'  => 'required|array',
        ];
    }
}
