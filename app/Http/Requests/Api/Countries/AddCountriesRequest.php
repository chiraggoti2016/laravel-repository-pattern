<?php

namespace App\Http\Requests\Api\Countries;

use Illuminate\Foundation\Http\FormRequest;

class AddCountriesRequest extends FormRequest
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
            'country_name'  => 'required',
            'sortname'      => 'required',
            'timezone'      => 'required',
            'country_lat'   => 'required',
            'country_lng'   => 'required',
        ];
    }
}
