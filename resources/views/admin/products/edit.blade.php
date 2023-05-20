@extends('layouts.admin')

@section('title')
    <title>Admin | Sản phẩm</title>
@endsection

@section('style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ asset('assets/admin/css/tab.css') }}">
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
                            <div class="form-group">
                                <label for="name">Tên sản phẩm :</label>
                                <input class="form-control" type="text" name="name" id="name"
                                       value="{{ $product->name }}">
                            </div>
                            <div class="form-group">
                                @error("name")
                                <small class="text-validate form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="price">Giá :</label>
                                <input class="form-control" type="text" name="price" id="price"
                                       value="{{ $product->price }}">
                            </div>
                            <div class="form-group">
                                @error("price")
                                <small class="text-validate form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="category_id">Danh mục :</label>
                                <select class="form-control select2-init" id="category_id" name="category_id">
                                    <option value="0">Chọn danh mục</option>
                                    {!! $htmlOption !!}
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="tags">Thẻ định danh :</label>
                                <select class="form-control tag-select2" multiple="multiple" name="tags[]" id="tags">
                                    @if(!empty( optional($product->tags) ))
                                        @foreach($product->tags as $tag)
                                            <option selected value="{{ $tag->name }}">{{ $tag->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="colors">Chọn màu :</label>
                                <select class="form-control tag-select2" multiple="multiple" name="colors[]"
                                        id="colors">
                                    @foreach($colors as $color)
                                        <option
                                            {{ $product->colors->contains('id', $color->id) ? 'selected' : '' }}  value="{{ $color->id }}">{{ $color->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="content">
                            <div class="form-group">
                                <label for="contents">Thông tin chi tiết:</label>
                                <textarea name="short_desc" class="form-control tinymce_editor_init" id="content"
                                          cols="30"
                                          rows="10">
                            {{ $product->short_desc }}
                        </textarea>
                            </div>
                            <div class="form-group">
                                <label for="contents">Mô tả sản phẩm :</label>
                                <textarea name="contents" class="form-control tinymce_editor_init" id="content"
                                          cols="30"
                                          rows="10">{{ $product->content }}</textarea>
                            </div>
                            <div class="form-group">
                                @error("contents")
                                <small class="text-validate form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="content">
                            <div class="form-group">
                                <label for="feature_image_path">Ảnh đại diện :</label>
                                <input class="form-control-file" type="file" name="feature_image_path"
                                       id="feature_image_path"
                                       multiple>
                            </div>
                            <div class="form-group d-flex align-items-center flex-wrap">
                                <div class="image-item mr-2">
                                    <img src="{{ asset( $product->feature_image_path )}}"
                                         alt="{{ $product->feature_image_name }}"
                                         title="{{ $product->name }}">
                                </div>
                            </div>
                            <div class="form-group">
                                @error("feature_image_path")
                                <small class="text-validate form-text text-danger">{{$message}}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="image_path">Ảnh sản phẩm :</label>
                                <input class="form-control-file" type="file" name="image_path[]" id="image_path"
                                       multiple>
                            </div>
                            <div class="form-group d-flex align-items-center flex-wrap">
                                @if(!empty( optional($product->images) ))
                                    @foreach($product->images as $image)
                                        <div class="image-item mr-2">
                                            <img src="{{ asset( $image->image_path )}}" alt="{{ $image->image_name }}"
                                                 title="{{ $image->image_name }}">
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="form-group">
                                @error("image_path[]")
                                <small class="text-validate form-text text-danger">{{$message}}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Trạng thái :</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="radio1" value="0"
                                {{ $product->status == 0 ? 'checked' : ''}}>
                            <label class="form-check-label" for="radio1">Chờ duyệt</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="radio2" value="1"
                                {{ $product->status == 1 ? 'checked' : ''}}>
                            <label class="form-check-label" for="radio2">Công khai</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
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
