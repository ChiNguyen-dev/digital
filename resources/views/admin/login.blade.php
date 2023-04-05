<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Open+Sans:wght@300;400;500;600;700;800&family=Poppins:wght@200;300;400;500;600;700&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;1,100&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset("assets/admin/css/reset.css") }}" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('assets/admin/css/login.css') }}">
    <title>Admin | Đăng nhập</title>
</head>
<body>
<section class="overlay">
    <div class="signin">
        <div class="signin__logo">
            <img src="{{ asset('assets/images/logo-admin.png') }}" alt="logo-admin.png">
        </div>
        <form action="{{ route('admin.login') }}" class="signin__form" method="POST">
            @csrf
            <div class="form__group">
                <label for="" class="form__label">Email</label>
                <input type="email" name="email" class="form__input" placeholder="Email của bạn là gì?" value="">
            </div>
            <div class="form__group form__group--pass">
                <label for="" class="form__label">Mật khẩu</label>
                <input type="password" name="password" class="form__input" value="admin!@#">
            </div>
            <div class="form__group">
                <button type="submit" class="form__submit" name="btn_login" value="login">
                    <span class="form__submit--text">Đăng nhập</span>
                    <i class="fa-solid fa-arrow-right form__submit--icon"></i>
                </button>
            </div>
            <div class="form__group-bottom">
                <div class="form__tos">
                    <input type="checkbox" name="remember_me" id="tos">
                    <label for="tos" class="form__tos-text">remember me</label>
                </div>
                <a href="#" class="form__forget-text">quên mật khẩu?</a>
            </div>
        </form>
        <div class="signin__date"></div>
    </div>
</section>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.2/jquery.min.js"></script>
<script src="{{ asset('assets/admin/js/login.js') }}" crossorigin="anonymous"></script>
</body>
</html>


