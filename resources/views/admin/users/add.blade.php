@extends('layouts.admin')

@section('title')
    <title>Admin | Thành viên</title>
@endsection

@section('content')
    <div id="content" class="container-fluid pt-4">
        <div class="card">
            @include('partials.admin.title-form',['name'=>'Thêm thành viên'])
            <div class="card-body">
                <form method="POST" action="{{ route('users.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="name">Họ và tên:</label>
                        <input class="form-control" type="text" name="name" id="name" value="">
                    </div>
                    <div class="form-group">
                        @error("name")
                        <small class="text-validate form-text text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input class="form-control" type="text" name="email" id="email" value="">
                    </div>
                    <div class="form-group">
                        @error("email")
                        <small class="text-validate form-text text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Mật khẩu:</label>
                        <input class="form-control" type="password" name="password" id="password" value="">
                    </div>
                    <div class="form-group">
                        @error("password")
                        <small class="text-validate form-text text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Vai trò:</label>
                        <select class="form-control select2-role" name="role_id[]" multiple>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        @error("role_id")
                        <small class="text-validate form-text text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Thêm mới</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('assets/admin/js/user/index.js') }}"></script>
@endsection
