<div class="block-account">
    <div class="infor">
        <div class="thumbnail">
            <img src="{{ asset('assets/images/avatar.png') }}"
                alt="">
        </div>
        <p>{{ Auth::guard('client')->user()->name }}</p>
        <a href="{{ route('Client.logout') }}" class="click_logout">Đăng xuất</a>
    </div>
    <ul>
        <li>
            <a href="{{ route('account.account') }}" class="title-info {{ $active == 'my-account' ? 'active' : '' }}">Tài khoản của tôi</a>
        </li>
        <li>
            <a href="" class="title-info {{ $active == 'my-order' ? 'active' : '' }}">Đơn hàng của tôi</a>
        </li>
        <li>
            <a href="" class="title-info {{ $active == 'change-pass' ? 'active' : '' }}">Đổi mật khẩu</a>
        </li>
        <li>
            <a href="" class="title-info {{ $active == 'favorite ' ? 'active' : '' }}">Sản phẩm yêu thích</a>
        </li>
    </ul>
</div>
