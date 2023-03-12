@extends('layouts.admin')

@section('title')
    <title>Admin | Sản phẩm</title>
@endsection

@section('content')
    <div class="row container-fluid ml-0 pt-4">
        <div class="card w-100" id="add-product">
            @include('partials.admin.title-form',['name'=>'Thêm sản phẩm'])
            <div class="card-body">
                <form method="post" action="{{ route('product.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">Tên sản phẩm :</label>
                        <input class="form-control @error('name') is-invalid @enderror" type="text" name="name"
                               id="name" value="{{ old('name') }}">
                    </div>
                    <div class="form-group">
                        @error("name")
                        <small class="text-validate form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="price">Giá :</label>
                        <input class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}"
                               type="text" name="price" id="price">
                    </div>
                    <div class="form-group">
                        @error("price")
                        <small class="text-validate form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="contents">Thông tin chi tiết:</label>
                        <textarea name="short_desc" class="form-control tinymce_editor_init" id="content" cols="30"
                                  rows="10">
                            {{ old('short_desc') }}
                        </textarea>
                    </div>
                    <div class="form-group">
                        @error("short_desc")
                        <small class="text-validate form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="contents">Mô tả sản phẩm :</label>
                        <textarea name="contents" class="form-contro tinymce_editor_init" id="content" cols="30"
                                  rows="10">{{ old('contents') }}</textarea>
                    </div>
                    <div class="form-group">
                        @error("contents")
                        <small class="text-validate form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="category_id">Danh mục :</label>
                        <select class="form-control select2-init" id="category_id" name="category_id">
                            <option value="">Chọn danh mục</option>
                            {!! $htmlOption !!}
                        </select>
                    </div>
                    <div class="form-group">
                        @error("category_id")
                        <small class="text-validate form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="tags">Thẻ định danh :</label>
                        <select class="form-control tag-select2" multiple="multiple" name="tags[]" id="tags"></select>
                    </div>
                    <div class="form-group">
                        @error("tags")
                        <small class="text-validate form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="colors">Màu :</label>
                        <select class="form-control color-select2" multiple="multiple" name="colors[]" id="colors">
                            @if(!empty($colors))
                                @foreach($colors as $color)
                                    <option value="{{ $color->id }}">{{ $color->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        @error("colors")
                        <small class="text-validate form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="feature_image_path">Ảnh đại diện :</label>
                        <input class="form-control-file" type="file" name="feature_image_path" id="feature_image_path"
                               multiple>
                    </div>
                    <div class="form-group">
                        @error("feature_image_path")
                        <small class="text-validate form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="image_path">Ảnh chi tiết :</label>
                        <input class="form-control-file" type="file" name="image_path[]" id="image_path" multiple>
                    </div>
                    <div class="form-group">
                        @error("image_path")
                        <small class="text-validate form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Trạng thái :</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="status-1" value="0" checked>
                            <label class="form-check-label" for="status-1">Chờ duyệt</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="status-2" value="1">
                            <label class="form-check-label" for="status-2">Công khai</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Thêm mới</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.tiny.cloud/1/jgew5yr3or5qbxhqeynvy0fm3csvna8vufl8852f2839gu6i/tinymce/4/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="{{ asset('assets/admin/js/product/add.js') }}"></script>
@endsection
