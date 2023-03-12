<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductAddRequest extends FormRequest
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
            'name' => 'bail|required|unique:products|max:255|min:10',
            'price' => 'bail|required',
            'category_id' => 'bail|required',
            'feature_image_path' => 'bail|required',
            'tags' => 'bail|required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên không được để trống',
            'price.required' => 'Giá không được để trống',
            'category_id.required' => 'Vui lòng chọn danh mục',
            'feature_image_path.required' => 'Vui lòng chọn ảnh đại diện cho sản phẩm',
            'tags.required' => 'Hãy tạo các thẻ tag cho sản phẩm',
        ];
    }
}
