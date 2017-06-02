<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CarModelRequest extends BaseFormrequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return array_merge([
            'name' => 'required|unique:car_models|alpha|min:3',
            'car_brand_id' => 'required|exists:car_brands,id'
        ], parent::rules());
    }
}
