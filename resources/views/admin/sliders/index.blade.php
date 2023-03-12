@extends('layouts.admin')

@section('title')
    <title>Admin | Slider</title>
@endsection

@section('content')
    <div class="row container-fluid ml-0 pt-2">
        @can(config('permissions.modules.sliders.add'))
            <div class="col-4">
                <div class="card">
                    @include('partials.admin.title-form',['name'=>'Thêm slider'])
                    <div class="card-body">
                        <form action="{{ route('sliders.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="name">Tên slider :</label>
                                <input class="form-control" type="text" name="name" id="name" placeholder="Nhập tên slider">
                            </div>
                            <div class="form-group">
                                @error("name")
                                <small class="text-validate form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group mb-4">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="inputGroupFile03" name="image_path">
                                    <label class="custom-file-label" for="inputGroupFile03">Choose file</label>
                                </div>
                            </div>
                            <div class="form-group">
                                @error("image_path")
                                <small class="text-validate form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Thêm mới</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-8">
                @else
                    <div class="col-12">
                        @endcan
                        <div class="card">
                            <div class="card-header font-weight-bold">Danh sách slider</div>
                            <div class="card-body">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Tên</th>
                                        <th scope="col">Ảnh</th>
                                        @canany([config('permissions.modules.sliders.edit'),config('permissions.modules.sliders.delete')])
                                            <th scope="col">Thao tác</th>
                                        @endcanany
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($sliders as $key => $slider)
                                        <tr>
                                            <td><strong>{{ $key + 1 }}</strong></td>
                                            <td>{{ $slider->name }}</td>
                                            <td class="pl-0">
                                                <div class="image-slider">
                                                    <img src="{{ asset($slider->image_path) }}"
                                                         alt="{{ $slider->image_name }}" title="{{ $slider->image_name }}">
                                                </div>
                                            </td>
                                            <td class="pl-4">
                                                @can(config('permissions.modules.sliders.edit'))
                                                    <a href="{{ route('sliders.edit',['id' => $slider['id']]) }}"
                                                       class="btn-edit text-success" type="button" title="Edit">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                @endcan
                                                @can(config('permissions.modules.sliders.delete'))
                                                    <a href="#" data-url="{{ route('sliders.delete',['id' => $slider['id']]) }}"
                                                       class="btn-delete text-danger" type="button" title="Delete">
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </a>
                                                @endcan
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
