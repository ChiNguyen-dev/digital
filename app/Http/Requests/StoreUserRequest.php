<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'name' => 'bail|required|max:32|min:6',
            'email' => 'bail|required|unique:users|max:32|min:6',
            'password' => 'bail|required|max:32|min:6',
            'role_id' => 'bail|required',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Họ và tên không được để trống',
            'email.required' => 'Email không được trống',
            'password.required' => 'Mật khẩu không được trống',
            'role_id.required' => 'Vai trò không được trống',
        ];
    }
}
