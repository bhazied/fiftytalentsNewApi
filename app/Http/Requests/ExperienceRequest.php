<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExperienceRequest extends BaseFormrequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'entreprise' => 'required',
            'function' => 'required|alpha',
            'actual_job' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required_if:actual_job,0',
            'description' => 'required',
            'c_profile_id' => 'required|exists:c_profiles,id'
        ];
    }
}
