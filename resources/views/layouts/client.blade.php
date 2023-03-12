<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;700&family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400;1,500&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;1,100&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
    @yield('vendors')
    <link rel="stylesheet" href="{{ asset('assets/client/css/style.css') }}">
    @yield('title')
</head>
<body>
<div id="wrapper">
    @include('partials.client.header')
    <div id="wp-content">
        @yield('content')
    </div>
    @include('partials.client.footer')
</div>
<div class="modal"></div>
<div id="loading">
    <div class="img-load">
        <img src="{{ asset('assets/images/loading.svg') }}" alt="loading">
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.2/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"></script>
<script src="{{ asset('assets/vendors/carousel/owl.carousel.min.js') }}"></script>
<script src="{{ asset('assets/client/js/app.js') }}"></script>
@yield('js')
</body>
</html>

