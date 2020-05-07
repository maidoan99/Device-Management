<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditProfileRequest extends FormRequest
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
            'first_name' => 'required|max:32',
            'last_name' => 'required|max:32', 
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'Bạn chưa nhập Họ và tên đệm',
            'last_name.required' => 'Bạn chưa nhập Tên',
            'first_name.max' => 'Họ và tên đệm của bạn phải giới hạn trong 32 kí tự',
            'last_name.max' => 'Tên của bạn phải giới hạn trong 32 kí tự',
        ];
    }
}
