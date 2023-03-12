<nav class="topnav shadow navbar-light bg-white d-flex">
    <div class="navbar-brand">
        <a href="{{ route('admin.dashboard') }}">
            <img
                src="https://cdn.shopify.com/s/files/1/0099/8739/1539/t/7/assets/footer-logo.png?v=176495128769315134041565611470"
                alt="logo-admin">
        </a>
    </div>
    <div class="nav-right">
        <div class="btn-group mr-auto">
            <button type="button" class="btn dropdown" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                <i class="plus-icon fas fa-plus-circle"></i>
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="#">Thêm bài viết</a>
                <a class="dropdown-item" href="">Thêm sản phẩm</a>
                <a class="dropdown-item" href="#">Thêm đơn hàng</a>
            </div>
        </div>
        <div class="btn-group">
            <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                {{ Auth::user()->name }}
            </button>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="{{ route('users.editPassword') }}">Đổi mật khẩu</a>
                <a class="dropdown-item" href="{{ route('users.account') }}">Cập nhật thông tin</a>
                <a class="dropdown-item" href="{{ route('admin.logout') }}">Thoát</a>
            </div>
        </div>
    </div>
</nav>
