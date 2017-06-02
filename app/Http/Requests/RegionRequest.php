<?php

namespace App\Http\Requests;

class RegionRequest extends BaseFormrequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return array_merge([
            'name' => 'required|unique:regions',
            'country_id' => 'required|exists:countries,id'
        ], parent::rules());
    }
}
