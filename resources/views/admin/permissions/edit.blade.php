@extends('layouts.admin')

@section('title')
    <title>Admin | Quyền</title>
@endsection

@section('content')
    <div id="content" class="container-fluid pt-4">
        <div class="card">
            @include('partials.admin.title-form',['name'=>'Chỉnh sửa quyền'])
            <div class="card-body">
                <form method="POST" action="{{ route('permissions.update',['id' => $permission->id]) }}">
                    @csrf
                    <div class="form-group">
                        <label for="name">Tên:</label>
                        <input class="form-control" type="text" name="name" id="name" value="{{ $permission->name }}">
                    </div>
                    <div class="form-group">
                        <label for="email">Mô tả:</label>
                        <input class="form-control" type="text" name="display_name" id="display_name"
                               value="{{ $permission->display_name }}">
                    </div>
                    <div class="form-group">
                        <label for="parent_id">Chọn quyền:</label>
                        <select class="form-control" name="parent_id" id="parent_id">
                            <option value="0">Chọn quyền cha</option>
                            {!! $htmlOptions !!}
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="key_code">Key code:</label>
                        <input class="form-control" type="text" name="key_code" id="key_code"
                               value="{{ $permission->key_code }}">
                    </div>
                    <button type="submit" class="btn btn-primary">Thêm mới</button>
                </form>
            </div>
        </div>
    </div>
@endsection

