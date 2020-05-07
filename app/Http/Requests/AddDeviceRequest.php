<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddDeviceRequest extends FormRequest
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
            'name' => 'required',
            'category' => 'required',
            'status' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Bạn chưa nhập Tên sản phẩm',
            'category.required' => 'Bạn chưa chọn Danh mục',
            'status.required' => 'Bạn chưa chọn Trạng thái',
        ];
    }
}
