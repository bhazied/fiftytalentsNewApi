<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CarBrandRequest extends BaseFormrequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return array_merge([
            'name' => 'required|unique:car_brands|alpha|min:3'
        ], parent::rules());
    }
}
