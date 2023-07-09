@extends('layouts.admin')

@section('title')
    <title>Admin | Thành viên</title>
@endsection

@section('content')
    <div class="row container-fluid ml-0 pt-2">
        <div class="card w-100" id="list-product">
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Danh sách thành viên</h5>
                <div class="form-search form-inline">
                    <form action="{{ route('users.search') }}" method="POST" class="d-flex">
                        @csrf
                        <input type="text" class="form-control form-search shadow-none" placeholder="Tìm kiếm"
                               name="search" value="{{ request()->search }}">
                        <button type="submit" class="button ml-3"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </form>
                </div>
            </div>
            <div class="card-body pb-0">
                <div class="analytic pb-3">
                    <div class="analytic__status">
                        <a href="" class="text-primary">
                            Số lượng <span class="text-muted">({{ $status->quantity }})</span>
                        </a>
                        <a href="" class="text-primary">
                            Thùng rác <span class="text-muted quantity-deleted">({{ $status->deleted }})</span>
                        </a>
                    </div>
                    <div class="analytic__add mr-0">
                        <div class="analytic__add mr-0">
                            <a href="{{ route('users.create') }}" class="button">
                                Thêm mới
                            </a>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-checkall mb-5">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Họ và Tên</th>
                        <th scope="col">Email</th>
                        <th scope="col">Số điện thoại</th>
                        <th scope="col" class="text-center">Thời gian</th>
                        <th scope="col" class="text-center">Tác vụ</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $key => $user)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ empty($user->phone_number) ? 'Chưa có' : $user->phone_number }}</td>
                            <td class="text-center">{{ $user->created_at }}</td>
                            <td class="d-flex align-items-center justify-content-center">
                                <a href="{{ route('users.edit',['id' => $user->id]) }}" class="btn-edit text-success"
                                   title="Edit">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a href="#" data-url="{{ route('users.delete',['id' => $user->id]) }}"
                                   class="btn-delete text-danger" title="Delete">
                                    <i class="fa-solid fa-trash-can"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $users->appends(['search' => request()->search])->links() }}
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/admin/js/user/index.js') }}"></script>
@endsection

