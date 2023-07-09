@extends('layouts.admin')

@section('title')
    <title>Admin | Đơn Hàng</title>
@endsection

@section('content')
    <div class="row container-fluid ml-0 pt-2">
        <div class="card w-100" id="list-product">
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Danh sách đơn hàng</h5>
                <div class="form-search form-inline">
                    <form action="{{ route('orders.search') }}" method="POST" class="d-flex">
                        @csrf
                        <input type="text" class="form-control form-search shadow-none" name="search"
                               placeholder="Tìm kiếm"
                               value="{{ request()->search }}">
                        <button type="submit" class="button ml-3"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="analytic">
                    <div class="analytic__status">
                        <a href="" class="text-primary">
                            Thành công <span class="text-muted">({{ $statistic->success }})</span>
                        </a>
                        <a href="" class="text-primary">
                            Đang xử lý <span class="text-muted">({{ $statistic->processing }})</span>
                        </a>
                        <a href="" class="text-primary">
                            Số lượng <span class="text-muted">({{ $statistic->quantity }})</span>
                        </a>
                        <a href="" class="text-primary">
                            Thùng rác
                            <span class="text-muted analytic__status__number-delete">({{ $statistic->delete }})</span>
                        </a>
                    </div>
                </div>
                <form action="{{ route('orders.update') }}" method="POST">
                    @csrf
                    <div class="form-action form-inline py-3">
                        @can(config('permissions.modules.orders.update'))
                            <select class="form-control mr-1 shadow-none" name="option">
                                <option selected value="">Chọn</option>
                                <option value="1">Thành công</option>
                                <option value="0">Đang xử lý</option>
                                <option value="2">Bỏ vào thùng rác</option>
                            </select>
                            <button type="submit" class="button ml-3">Áp dụng</button>
                        @endcan
                    </div>
                    <table class="table table-striped table-checkall mb-3">
                        <thead>
                        <tr>
                            @can(config('permissions.modules.orders.update'))
                                <th scope="col"><input name="check" type="checkbox" class="checkAll"></th>
                            @endcan
                            <th scope="col" class="text-center">#</th>
                            <th scope="col" class="text-center">Mã đơn hàng</th>
                            <th scope="col" class="text-center">Khách hàng</th>
                            <th scope="col" class="text-center">Giá trị</th>
                            <th scope="col" class="text-center">Trạng thái</th>
                            <th scope="col" class="text-center">Thời gian</th>
                            <th scope="col" class="text-center">Chi tiết</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($orders as $key => $order)
                            <tr>
                                @can(config('permissions.modules.orders.update'))
                                    <td>
                                        <input type="checkbox" value="{{ $order->getId() }}" class="checkBox" name="check[]">
                                    </td>
                                @endcan
                                <th class="text-center align-middle" scope="row">{{ $key + 1 }}</th>
                                <td class="text-center">#{{ $order->getOrderCode() }}</td>
                                <td class="text-center">{{ $order->getCustomerName() }}
                                    <br>{{ $order->getPhoneNumber() }}
                                </td>
                                <td class="text-center">{{ number_format($order->getTotal(), 0, ',', '.') }}₫</td>
                                <td class="text-center">
                                    @php
                                        $class = $order->isStatus() == 0 ? 'badge-warning' : 'badge-success';
                                        $text = $order->isStatus() == 0 ? 'Đang xử lý' : 'Thành công';
                                    @endphp
                                    <span class="badge {{ $class }}">{{ $text }}</span>
                                </td>
                                <td class="text-center">{{ $order->getOrderDate() }}</td>
                                <td class="text-center">
                                    <a href="{{ route('orders.detail', ['id' => $order->getId()]) }}">Chi tiết</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </form>
                {{ $ordersPaginate->links() }}
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('assets/admin/js/order/index.js') }}"></script>
@endsection
