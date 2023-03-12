@extends('layouts.admin')

@section('title')
    <title>Admin | Thành viên</title>
@endsection

@section('content')
    <div id="content" class="container-fluid pt-4">
        <div class="card">
            @include('partials.admin.title-form',['name'=>'Chỉnh sửa thông tin'])
            <div class="card-body">
                <form method="POST" action="{{ route('users.update',['id' => $user->id]) }}">
                    @csrf
                    <div class="form-group">
                        <label for="name">Họ và tên:</label>
                        <input class="form-control" type="text" name="name" id="name" value="{{ $user->name }}">
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input class="form-control" type="text" name="email" id="email" value="{{ $user->email }}">
                    </div>
                    <div class="form-group">
                        <label for="password">Vai trò:</label>
                        <select class="form-control select2-role" name="role_id[]" multiple>
                            @foreach($roles as $role)
                                <option
                                    {{ $user->roles->contains('id',$role->id) ? 'selected' : '' }} value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('assets/admin/js/user/index.js') }}"></script>
@endsection
