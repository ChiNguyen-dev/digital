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
        <div class="dropdown-menu-user">
            <img src="{{ asset('assets/images/avatar-default.png') }}" alt="avatar user default" class="logo">
            <div class="sub-menu-wrap">
                <div class="sub-menu">
                    <div class="user-infor">
                        <img src="{{ asset('assets/images/avatar-default.png') }}" alt="avatar user default">
                        <h3>{{ auth()->user()->name }}</h3>
                    </div>
                    <hr>
                    <a href="{{ route('users.account') }}" class="sub-menu-link">
                        <img src="{{ asset('assets/images/profile.png') }}" alt="avatar user default">
                        <p>Edit profile</p>
                        <span>></span>
                    </a>
                    <a href="" class="sub-menu-link">
                        <img src="{{ asset('assets/images/setting.png') }}" alt="avatar user default">
                        <p>Setting & Privacy</p>
                       <span>></span>
                    </a>
                    <a href="" class="sub-menu-link">
                        <img src="{{ asset('assets/images/help.png') }}" alt="avatar user default">
                        <p>Help & Support</p>
                       <span>></span>
                    </a>
                    <a href="{{ route('admin.logout') }}" class="sub-menu-link">
                        <img src="{{ asset('assets/images/logout.png') }}" alt="avatar user default">
                        <p>Logout</p>
                       <span>></span>
                    </a>
                </div>
            </div>
            <img src="{{ asset('assets/images/arrow.png') }}" class="arrow-user">
        </div>
    </div>
</nav>
