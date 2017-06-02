<?php

namespace App\Http\Requests;

class CountryRequest extends BaseFormrequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return array_merge([
            'name' => 'required|unique:countries',
            'code' => 'required|unique:countries',
            'long_code' => 'required',
            'prefix' => 'required',
            'picture' => 'required|image:mime:jpg,png',
        ], parent::rules());
    }
}
