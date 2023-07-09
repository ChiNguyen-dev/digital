@extends('layouts.admin')

@section('title')
    <title>Admin | Sản phẩm</title>
@endsection

@section('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"/>
    <link rel="stylesheet" href="{{ asset('assets/admin/css/tab.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/productForm.css') }}">
@endsection

@section('content')
    <div class="row container-fluid ml-0 pt-4">
        <div class="card w-100" id="add-product">
            @php $arr_title = ['Thông tin sản phẩm', 'Mô tả và chi tiết sản phẩm', 'Ảnh sản phẩm']; @endphp
            @include('partials.admin.tab', ['data' => $arr_title])
            <div class="card-body">
                <form method="post" action="{{ route('product.update',['id' => $product->id ]) }}"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="content_box">
                        <div class="content active">
                            <div class="form-input-group d-flex align-items-center">
                                <label for="name">Tên sản phẩm (<span class="text-danger">*</span>):</label>
                                <input type="text" name="name" id="name" value="{{ $product->name }}">
                            </div>
                            <div class="validate">
                                @error('name')
                                <small class="text-validate form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-input-group d-flex align-items-center">
                                <label for="price">Giá bán (<span class="text-danger">*</span>):</label>
                                <input value="{{ $product->price }}" type="text" name="price" id="price"
                                       placeholder="VD: 500.000đ">
                            </div>
                            <div class="validate">
                                @error('price')
                                <small class="text-validate form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-input-group d-flex align-items-center">
                                <label for="category_id">Danh mục (<span class="text-danger">*</span>):</label>
                                <select id="category_id" name="category_id">
                                    <option value="0">Chọn danh mục</option>
                                    {!! $htmlOption !!}
                                </select>
                            </div>
                            <div class="form-input-group d-flex align-items-center">
                                <label for="tags">Thẻ định danh (<span class="text-danger">*</span>):</label>
                                <select class="tag-select2 custom-selection" multiple="multiple" name="tags[]"
                                        id="tags">
                                    @if(!empty( optional($product->tags) ))
                                        @foreach($product->tags as $tag)
                                            <option selected value="{{ $tag->name }}">{{ $tag->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="validate">
                                @error('tags')
                                <small class="text-validate form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-input-group d-flex align-items-center">
                                <label for="colors">Màu sắc (<span class="text-danger">*</span>):</label>
                                <select class="color-select2 custom-selection" multiple="multiple" name="colors[]" id="colors">
                                    @php $productColor = $product->colors; @endphp
                                    @foreach($colors as $color)
                                        @php $selected = $productColor->contains('id', $color->id) ? 'selected' : ''; @endphp
                                        <option {{ $selected }}  value="{{ $color->id }}">
                                            {{ $color->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="validate">
                                @error('colors')
                                <small class="text-validate form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-input-group d-flex align-items-center">
                                <label>Trạng thái :</label>
                                <div class="form-check mr-3">
                                    <input class="form-check-input" type="radio" name="status" id="status-1" value="0"
                                        {{ $product->status == 0 ? 'checked' : ''}}>
                                    <label class="form-check-label" for="status-1">Chờ duyệt</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="status-2" value="1"
                                        {{ $product->status == 1 ? 'checked' : ''}}>
                                    <label class="form-check-label" for="status-2">Đăng bán</label>
                                </div>
                            </div>
                        </div>
                        <div class="content">
                            <div class="form-input-group mb-4 pl-2">
                                <label for="contents" class="pb-2 pl-0">Thông tin chi tiết :</label>
                                <textarea name="short_desc" class="form-control tinymce_editor_init" id="content" cols="30" rows="10">
                                    {{ $product->short_desc }}
                                </textarea>
                            </div>
                            <div class="form-input-group mb-4 pl-2">
                                <label for="contents" class="pb-2 pl-0">Mô tả sản phẩm :</label>
                                <textarea name="contents" class="form-control tinymce_editor_init" id="content" cols="30" rows="10">
                                    {{ $product->content }}
                                </textarea>
                            </div>
                        </div>
                        <div class="content">
                            <div class="form-input-group">
                                <label for="feature_image_path" class="pb-2 pl-0">Ảnh đại diện :</label>
                                <div class="box-thumbnail feature_image_path pb-3">
                                    <img src="{{ asset( $product->feature_image_path )}}"
                                         alt="{{ $product->feature_image_name }}"
                                         title="{{ $product->name }}">
                                </div>
                                <div class="input-file-group">
                                    <input type="file" name="feature_image_path" id="feature_image_path">
                                    <label for="feature_image_path">
                                        Tải ảnh
                                    </label>
                                </div>
                            </div>
                            <div class="form-input-group">
                                @error('feature_image_path')
                                <small class="text-validate form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            @php $images = $product->images;@endphp
                            <div class="form-input-group">
                                <label for="image_path" class="pb-2 pl-0">Ảnh chi tiết ({{ $images->count() }}+):</label>
                                <div class="box-thumbnail image_path pb-3">
                                    @if(!empty( $images ))
                                        @foreach($images as $image)
                                            <img src="{{ asset( $image->image_path )}}" alt="{{ $image->image_name }}"
                                                 title="{{ $image->image_name }}">
                                        @endforeach
                                    @endif
                                </div>
                                <div class="input-file-group">
                                    <input type="file" name="image_path[]" id="image_path" multiple>
                                    <label for="image_path">
                                        Tải ảnh
                                    </label>
                                </div>
                            </div>
                            <div class="form-input-group">
                                @error("image_path.*")
                                <small class="text-validate form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="button-group">
                        <a href="{{ route('product.index') }}" class="button-cancel">Hủy</a>
                        <button type="submit" class="button">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/jgew5yr3or5qbxhqeynvy0fm3csvna8vufl8852f2839gu6i/tinymce/4/tinymce.min.js"
            referrerpolicy="origin"></script>
    <script src="{{ asset('assets/admin/js/product/add.js') }}"></script>
@endsection
