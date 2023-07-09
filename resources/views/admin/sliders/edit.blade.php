@extends('layouts.admin')

@section('title')
    <title>Admin | Slider</title>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/productForm.css') }}">
@endsection

@section('content')
    <div class="row container-fluid ml-0 pt-2">
        <div class="col-5">
            <div class="card">
                @include('partials.admin.title-form',['name'=>'Chỉnh sửa slider'])
                <div class="card-body">
                    <form action="{{ route('sliders.update', ['id' => $slider->id]) }}" method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="form-input-group d-flex align-items-center">
                            <input type="text" name="name" id="name" value="{{ $slider->name }}">
                        </div>
                        <div class="validate">
                            @error("name")
                            <small class="text-validate form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-input-group">
                            <div class="d-flex align-items-center">
                                <div class="input-file-group mr-3">
                                    <input type="file" name="image_path" id="image_path">
                                    <label for="image_path">Chọn ảnh</label>
                                </div>
                                <div class="button-group mt-0">
                                    <button type="submit" class="button button-slider">Lưu</button>
                                </div>
                            </div>
                            <div class="box-thumbnail image_path pt-3">
                                <img style="max-width: 250px;height: auto;margin: 0 auto;"
                                     src="{{ asset($slider->image_path) }}"
                                     alt="{{ $slider->image_name }}"
                                     title="{{ $slider->image_name }}">
                            </div>
                        </div>
                        <div class="validate">
                            @error("image_path")
                            <small class="text-validate form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-7">
            <div class="card">
                <div class="card-header font-weight-bold">Danh sách slider</div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Tên</th>
                            <th scope="col">Ảnh</th>
                            <th scope="col">Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($sliders as $key => $slider)
                            <tr>
                                <td><strong>{{ $key + 1 }}</strong></td>
                                <td>{{ $slider->name }}</td>
                                <td class="pl-0">
                                    <div class="image-slider">
                                        <img src="{{ asset($slider->image_path) }}" alt="{{ $slider->image_name }}"
                                             title="{{ $slider->image_name }}">
                                    </div>
                                </td>
                                <td class="pl-4">
                                    <a href="{{ route('sliders.edit',['id' => $slider['id']]) }}"
                                       class="btn-edit text-success" type="button" title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="#" data-url="{{ route('sliders.delete',['id' => $slider['id']]) }}"
                                       class="btn-delete text-danger" type="button" title="Delete">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $sliders->links() }}
            </div>

        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/admin/js/slider/index.js')  }}"></script>
@endsection
