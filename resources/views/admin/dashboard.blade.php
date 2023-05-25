@extends('layouts.admin')

@section('title')
    <title>Admin | Trang chủ</title>
@endsection

@section('content')
    <div class="container-fluid py-2">
        <div class="row">
            <div class="col">
                <div class="card border-0 text-white bg-info  mb-3">
                    <div class="card-header card-header--bg">DOANH THU</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ number_format($progress->revenue,0,',','.') }} VNĐ</h5>
                        <p class="card-text">Doanh số hệ thống</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card border-0 text-white bg-success mb-3 ">
                    <div class="card-header card-header--bg">ĐƠN HÀNG THÀNH CÔNG</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $progress->success }}</h5>
                        <p class="card-text">Đơn hàng giao dịch thành công</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card border-0 text-dark bg-warning mb-3">
                    <div class="card-header card-header--bg font-weight-bold">ĐANG XỬ LÝ</div>
                    <div class="card-body">
                        <h5 class="card-title font-weight-bold">{{ $progress->processing }}</h5>
                        <p class="card-text">Số lượng đơn hàng đang xử lý</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card border-0 text-white bg-danger mb-3">
                    <div class="card-header card-header--bg">ĐƠN HÀNG HỦY</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $progress->delete }}</h5>
                        <p class="card-text">Số đơn bị hủy trong hệ thống</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header font-weight-bold">ĐƠN HÀNG MỚI</div>
            <div class="card-body pb-0">
                <table class="table table-striped mb-4">
                    <thead>
                    <tr>
                        <th scope="col" class="text-center">#</th>
                        <th scope="col" class="text-center">Mã đơn hàng</th>
                        <th scope="col" class="text-center">Khách hàng</th>
                        <th scope="col" class="text-center">Tổng tiền</th>
                        <th scope="col" class="text-center">Trạng thái</th>
                        <th scope="col" class="text-center">Thời gian</th>
                        <th scope="col" class="text-center">Chi tiết</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $key => $v)
                        <tr>
                            <th class="text-center align-middle" scope="row">{{ $key + 1 }}</th>
                            <td class="text-center">#{{ $v->code }}</td>
                            @php
                                $customer = $v->customer;
                                $classElement = $v->status == 0 ? 'badge-warning' : 'badge-success';
                                $valueElement = $v->status == 0 ? 'Đang xử lý' : 'Thành công';
                            @endphp
                            <td class="text-center">{{ $customer->name }} <br>{{ $customer->phone_number }}</td>
                            <td class="text-center">{{ number_format($v->total,0,',','.') }}₫</td>
                            <td class="text-center"><span class="badge {{ $classElement }}">{{ $valueElement }}</span></td>
                            <td class="text-center">{{ $v->created_at->format('d/m/Y h:i:s')  }}</td>
                            <td class="text-center"><a href="{{ route('orders.detail',['id' => $v->id]) }}">Chi tiết</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $data->links() }}
            </div>
        </div>
    </div>
@endsection

