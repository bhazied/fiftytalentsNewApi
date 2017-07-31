<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class RecommendationRequest extends BaseFormrequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if (Str::lower($this->method()) == 'post') {
            return array_merge(parent::rules(), [
                'name' => 'required',
                'function' => 'required',
                'email' => 'required|email',
                'c_profile_id' => 'required|numeric',
            ]);
        } elseif (Str::lower($this->method()) == 'put' || Str::lower($this->method()) == 'patch') {
            return array_merge(parent::rules(), [
                'name' => 'required',
                'function' => 'required',
                'c_profile_id' => 'required|numeric',
            ]);
        }
    }
}
