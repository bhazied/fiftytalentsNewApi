<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StateRequest extends BaseFormrequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return  array_merge([
            'name' => 'required|unique:states',
            'country_id' => 'required|exists:countries,id',
            'region_id' => 'required|exists:regions,id'
        ], parent::rules());
    }
}
