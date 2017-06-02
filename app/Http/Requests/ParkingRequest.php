<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Validator;

class ParkingRequest extends BaseFormrequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return array_merge([
            'name'         => 'required|unique:parkings',
            'capacity'     => 'required|numeric',
            'description'  => 'required|alpha_num|min:100',
            'lattitude'    => 'nullable',
            'longitude'    => 'nullable',
            'opening_time' => 'required_if:is_24_opened,false|date_format:H:i',
            'closure_time' => 'required_if:is_24_opened,false|date_format:H:i|after:opening_time',
            'day_of_work'  => 'required_if:is_7_Opened, false',
            'has_wash'     => 'required|boolean',
            'has_coffee'   => 'required|boolean',
            'has_shop'     => 'required|boolean',
            'is_opened'    => 'required|boolean',
            'is_24_opened' => 'required|boolean',
            'is_7_opened'  => 'required|boolean',
            'region_id'    => 'required|exists:regions,id',
            'state_id'     => 'required|exists:states,id',
        ], parent::rules());
    }
}
