<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRegisterRequest extends FormRequest
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
            'password' => 'bail|required|min:6',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Họ và tên không được để trống',
            'email.required' => 'Email không được để trống',
            'phone_number.required' => 'Số điện thoại không được để trống',
            'phone_number.numeric' => 'Số điện thoại phải là chữ số',
            'phone_number.min' => 'Số điện thoại phải 10 chữ số trở lên',
            'password.required' => 'Mật khẩu không được để trống',
            'password.min' => 'Mật khẩu phải 6 kí tự trở lên',
        ];
    }
}
