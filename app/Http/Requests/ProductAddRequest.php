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
            'name' => 'bail|required|unique:products|max:255|min:10',
            'price' => 'bail|required|numeric',
            'category_id' => 'bail|required',
            'feature_image_path' => 'bail|required',
            'image_path[]' => 'bail|required',
            'tags' => 'bail|required',
            'colors' => 'bail|required',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Vui lòng nhập tên sản phẩm.',
            'price.required' => 'Vui lòng nhập giá sản phẩm.',
            'price.numeric' => 'Giá sản phẩm phải là chữ số.',
            'category_id.required' => 'Vui lòng chọn danh mục sản phẩm.',
            'feature_image_path.required' => 'Vui lòng chọn ảnh đại diện cho sản phẩm.',
            'image_path[].required' => 'Vui lòng chọn ảnh chi tiết cho sản phẩm.',
            'tags.required' => 'Hãy tạo các thẻ tag cho sản phẩm.',
            'colors.required' => 'Vui lòng chọn màu sắc cho sản phẩm.',
        ];
    }
}
