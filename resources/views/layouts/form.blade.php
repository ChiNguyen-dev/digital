<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"/>
    <link
        href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;700&family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400;1,500&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;1,100&display=swap"
        rel="stylesheet">
    <title>Digital - Account</title>
    <link rel="stylesheet" href="{{ asset('assets/client/css/login/login.css') }}">
</head>
<body>
<div id="wrapper">
    <div class="wp-left">
        <div class="left-thumbnail">
            <img src="https://accounts.haravan.com/img/login_banner.svg" alt="">
        </div>
    </div>
    <div class="wp-right">
        <div class="right-form">
            <div class="name-powered">
                Powered by
                <i class="fa-brands fa-gripfire"></i>
                <span>Havaran</span>
            </div>
            <div class="form">
                @yield('content')
            </div>
        </div>
    </div>
</div>
</body>
</html>
