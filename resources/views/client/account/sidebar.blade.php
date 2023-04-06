<div class="block-account">
    <div class="infor">
        <div class="thumbnail">
            <img src="https://cdn-user-icons.flaticon.com/98578/98578114/1680694404780.svg?token=exp=1680695305~hmac=4538ed6f49608897a3fc0a061fbee4fc"
                alt="">
        </div>
        <p>{{ Auth::guard('client')->user()->name }}</p>
        <a href="{{ route('Client.logout') }}" class="click_logout">Đăng xuất</a>
    </div>
    <ul>
        <li>
            <a href="{{ route('account.index') }}" class="title-info {{ $active == 'my-account' ? 'active' : '' }}">Tài khoản của tôi</a>
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
