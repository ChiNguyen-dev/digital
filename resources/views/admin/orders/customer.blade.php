@extends('layouts.admin')

@section('title')
    <title>Admin | Khách Hàng</title>
@endsection

@section('content')
    <div class="row container-fluid ml-0 pt-2">
        <div class="card w-100" id="list-product">
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Danh sách khách hàng</h5>
                <div class="form-search form-inline">
                    <form action="#" class="d-flex">
                        <input type="text" class="form-control form-search" placeholder="Tìm kiếm">
                        <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary ml-2">
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="analytic pb-3">
                    <div class="analytic__status">
                        <a href="#" class="text-primary">
                            Số lượng <span class="text-muted">({{ $customers->count() }})</span>
                        </a>
                        <a href="#" class="text-primary">
                            Thùng rác <span class="text-muted quantity-deleted">({{ $qtyDeleted }})</span>
                        </a>
                    </div>
                </div>
                <table class="table table-striped table-checkall mb-3">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Họ và Tên</th>
                        <th scope="col">Số điện thoại</th>
                        <th scope="col">Email</th>
                        <th scope="col">Thời gian</th>
                        @can(config('permissions.modules.customers.delete'))
                            <th scope="col" class="text-center">Tác vụ</th>
                        @endcan
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($customers as $key => $customer)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $customer->name }}</td>
                            <td>{{ $customer->phone_number }}</td>
                            <td>{{ $customer->email }}</td>
                            <td>{{ $customer->created_at }}</td>
                            @can(config('permissions.modules.customers.delete'))
                                <td class="d-flex align-items-center justify-content-center">
                                    <a href="#" data-url="{{ route('customer.delete') }}" data-id="{{ $customer->id }}"
                                       class="btn-delete text-danger" title="Delete">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </a>
                                </td>
                            @endcan
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/admin/js/customer/index.js') }}"></script>
@endsection

