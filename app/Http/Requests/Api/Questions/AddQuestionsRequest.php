<?php

namespace App\Http\Requests\Api\Questions;

use Illuminate\Foundation\Http\FormRequest;

class AddQuestionsRequest extends FormRequest
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
            'category'              => "required",
            'fields'                => "nullable",
            'information'           => "required",
            'question'              => "required",
            'response_collector'    => "required",
            'scope'                 => "required",
            'sub_question'          => "nullable",
        ];
    }
}
