<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'passCurrent' => 'bail|required|max:32|min:6',
            'password' => 'bail|required|unique:users|max:32|min:6',
            'passConfirm' => 'bail|required|max:32|min:6',
        ];

    }

    public function messages()
    {
        return [
            'passCurrent.required' => 'Vui lòng nhập mật khẩu hiện tại',
            'password.required' => 'Mật khẩu không được trống',
            'passConfirm.required' => 'Vui lòng xác nhận mật khẩu',
            'passCurrent.min' => 'Mật khẩu có ít nhất 6 kí tự',
            'password.min' => 'Mật khẩu có ít nhất 6 kí tự',
            'passConfirm.min' => 'Mật khẩu có ít nhất 6 kí tự',
            'passCurrent.max' => 'Mật khẩu tối đa 32 kí tự',
            'password.max' => 'Mật khẩu tối đa 32 kí tự',
            'passConfirm.max' => 'Mật khẩu tối đa 32 kí tự',
        ];
    }
}
