@extends('layouts.admin')

@section('title')
    <title>Danh mục</title>
@endsection

@section('content')
    <div class="row container-fluid ml-0 pt-2">
        <div class="col-4">
            <div class="card">
                @include('partials.admin.title-form',['name'=>'Chỉnh sửa màu'])
                <div class="card-body">
                    <form action="{{ route('color.update',['id'=> $color->id]) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Tên màu :</label>
                            <input class="form-control" type="text" name="name" id="name" value="{{ $color->name }}">
                        </div>
                        <div class="form-group">
                            @error("name")
                            <small class="text-validate form-text text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="style">Mã màu :</label>
                            <input class="form-control" type="color" name="style" id="style"
                                   value="{{ $color->style }}">
                        </div>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-8">
            <div class="card">
                <div class="card-header font-weight-bold">Bảng màu</div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Tên màu</th>
                            <th scope="col">Hex</th>
                            <th scope="col">Màu</th>
                            <th scope="col">Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($colors as $key => $color)
                            <tr>
                                <th scope="row">{{$key + 1}}</th>
                                <td>{{ $color['name'] }}</td>
                                <td>{{ $color['style'] }}</td>
                                <td>
                                    <div class="col-style" style="background-color: {{ $color['style'] }}">*</div>
                                </td>
                                <td class="pl-4">
                                    <a href="{{ route('color.edit',['id' => $color['id']]) }}"
                                       class="btn-edit text-success" type="button" title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="#" data-url="{{ route('color.delete') }}" data-id="{{ $color->id }}"
                                       class="btn-delete text-danger" type="button" title="Delete">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/admin/js/color/index.js') }}"></script>
@endsection
