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
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'bail|required',
            'email' => 'bail|required',
            'phone_number' => 'bail|required|numeric',
            'address' => 'bail|required',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Họ tên không được trống',
            'email.required' => 'Email không được trống',
            'address.required' => 'Địa chỉ không được trống',
            'phone_number.required' => 'Số điện thoại không được trống',
            'phone_number.numeric' => 'Số điện thoại phải là số',
        ];
    }
}
