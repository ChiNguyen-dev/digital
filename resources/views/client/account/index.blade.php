@extends('layouts.client')

@section('title')
    <title>Trang khách hàng</title>
@endsection

@section('content')
    <section class="bread-crumb">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="home">
                            <a href="{{ route('client.home') }}">Trang chủ</a>
                            <span class="mr_lr">&nbsp;/&nbsp;</span>
                        </li>
                        <li>
                            <a href="{{ route('account.account') }}">Tài khoản</a>
                        </li>
                        <li class="last">
                            <h5>Tài khoản</h5>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <section class="page_customer_account">
        <div class="wp-container">
            <div class="row">
                <div class="col-left-ac">
                    @include('client.account.sidebar', ['active' => 'my-account'])
                </div>
                <div class="col-right-ac">
                    <h1 class="title-head">
                        Thông tin cá nhân
                        <button type="button" class="btn">Sửa thông tin</button>
                    </h1>
                    <div class="name-account">
                        <p>
                            <strong>Họ và tên:</strong>
                            {{ Auth::guard('client')->user()->name }}
                        </p>
                        <p>
                            <strong>Địa chỉ email:</strong>
                            {{ Auth::guard('client')->user()->email }}
                        </p>
                        <p>
                            <strong>Điện thoại:</strong>
                            {{ Auth::guard('client')->user()->phone_number }}
                        </p>
                        <p>
                            <strong>Ngày tạo:</strong>
                            {{ Auth::guard('client')->user()->created_at }}
                        </p>
                        <p>
                            <strong>Địa chỉ:</strong>
                            {{ Auth::guard('client')->user()->address }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="op_address opened"></div>
    <div class="modal-address animate__animated">
        <div class="closed_pop">
            <i class="fa-solid fa-xmark"></i>
        </div>
        <h2 class="title_pop">Sửa thông tin địa chỉ</h2>
        <form action="{{ route('account.account') }}" method="POST">
            @csrf
            <div class="pop_bottom">
                <div class="form_address">
                    <div class="row">
                        <div class="fied col-md-6">
                            <fieldset class="form-group">
                                <input type="text" class="form-control" name="name"
                                    value="{{ Auth::guard('client')->user()->name }}" placeholder=" ">
                                <label>Họ tên</label>
                            </fieldset>
                        </div>
                        <div class="fied col-md-6">
                            <fieldset class="form-group">
                                <input type="number" class="form-control" name="phone_number"
                                    value="{{ Auth::guard('client')->user()->phone_number }}" placeholder=" ">
                                <label>Số điện thoại</label>
                            </fieldset>
                        </div>
                    </div>
                    <div class="row">
                        <div class="fied col-md-12">
                            <fieldset class="form-group">
                                <input type="email" class="form-control" name="email" id="email" placeholder=" "
                                    data-url="{{ route('account.validate') }}"
                                    value="{{ Auth::guard('client')->user()->email }}">
                                <label>Email</label>
                            </fieldset>
                            <small id="error-email">Lỗi</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="fied col-md-12">
                            <fieldset class="form-group">
                                <input type="text" class="form-control" name="address"
                                    value="{{ Auth::guard('client')->user()->address }}" placeholder=" ">
                                <label>Địa chỉ</label>
                            </fieldset>
                        </div>
                    </div>
                    <div class="group-country d-flex">
                        <fieldset class="form-group select-field">
                            <select name="province" id="province" class="form-control"
                                data-url="{{ route('account.address') }}" data-key='province'>
                                <option value="">---</option>
                                @foreach ($provinces as $province)
                                    <option value="{{ $province->matp }}">{{ $province->name }}</option>
                                @endforeach
                            </select>
                            <label>Tỉnh thành</label>
                        </fieldset>
                        <fieldset class="form-group select-field">
                            <select name="district" id="district" class="form-control" disabled="disabled"
                                data-url="{{ route('account.address') }}" data-key='district'>
                                <option value="">---</option>
                            </select>
                            <label>Quận huyện</label>
                        </fieldset>
                        <fieldset class="form-group select-field">
                            <select name="ward" id="ward" class="form-control" disabled="disabled">
                                <option value="">---</option>
                            </select>
                            <label>Phường xã</label>
                        </fieldset>
                    </div>
                </div>
                <div class="btn-row text-center">
                    <button type="button" class="btn btn-close">HỦY</button>
                    <button type="submit" class="btn btn-sm">LƯU</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/client/js/account/index.js') }}"></script>
@endsection
