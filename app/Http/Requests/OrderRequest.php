<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'name' => 'bail|required',
            'email' => 'bail|required',
            'phone' => 'bail|required',
            'address' => 'bail|required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Họ tên không được trống',
            'email.required' => 'Email không được trống',
            'phone.required' => 'Số điện thoại không được trống',
            'address.required' => 'Vui lòng chọn địa chỉ mua hàng',
        ];
    }
}
