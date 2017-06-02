<?php
/**
 * Created by PhpStorm.
 * User: dev03
 * Date: 15/05/17
 * Time: 15:43
 */

namespace app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Str;

class BaseFormrequest extends FormRequest
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

    protected function formatErrors(Validator $validator)
    {
        return ['error' => parent::formatErrors($validator)];
    }

    public function rules()
    {
        if (Str::lower($this->method()) == 'post') {
            return [
                'creator_user_id' => 'nullable',
                'created_at' => 'nullable'
            ];
        } elseif (Str::lower($this->method()) == 'put' || Str::lower($this->method()) == 'patch') {
            return [
                'modifier_user_id' => 'nullable',
                'updated_at' => 'nullable'
            ];
        }
    }
}
