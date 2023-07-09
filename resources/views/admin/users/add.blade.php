@extends('layouts.admin')

@section('title')
    <title>Admin | Thành viên</title>
@endsection

@section('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"/>
    <link rel="stylesheet" href="{{ asset('assets/admin/css/productForm.css') }}">
@endsection

@section('content')
    <div id="content" class="container-fluid pt-4">
        <div class="card">
            @include('partials.admin.title-form',['name'=>'Thêm thành viên'])
            <div class="card-body">
                <form method="POST" action="{{ route('users.store') }}">
                    @csrf
                    <div class="form-input-group d-flex align-items-center">
                        <label for="name">Họ tên (<span class="text-danger">*</span>):</label>
                        <input class="form-control" type="text" name="name" id="name" value="">
                    </div>
                    <div class="validate validate-user--customize">
                        @error('name')
                        <small class="text-validate form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-input-group d-flex align-items-center">
                        <label for="email">Email (<span class="text-danger">*</span>):</label>
                        <input class="form-control" type="text" name="email" id="email" value="">
                    </div>
                    <div class="validate validate-user--customize">
                        @error("email")
                        <small class="text-validate form-text text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-input-group d-flex align-items-center">
                        <label for="password">Mật khẩu (<span class="text-danger">*</span>):</label>
                        <input class="form-control" type="password" name="password" id="password" value="">
                    </div>
                    <div class="validate validate-user--customize">
                        @error("password")
                        <small class="text-validate form-text text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-input-group d-flex align-items-center">
                        <label for="password" style="flex-basis: 16.8%;">Vai trò (<span class="text-danger">*</span>):</label>
                        <select class="select2-role custom-selection" name="role_id[]" multiple>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="validate validate-user--customize">
                        @error("role_id")
                        <small class="text-validate form-text text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="button-group">
                        <a href="{{ route('users.index') }}" class="button-cancel">Hủy</a>
                        <button type="submit" class="button">Thêm mới</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('assets/admin/js/user/select2.js') }}"></script>
@endsection
