<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title', 'Businos Line')</title>
    <link rel="icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" sizes="any">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/favicon/favicon-16x16.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/img/favicon/apple-touch-icon.png') }}">
    <link rel="stylesheet" href="{{ asset('templates/public/css/styles.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/businos.css') }}">
</head>
<body>
<div id="ajax-loader" class="ajax-loader d-none"><div class="spinner-border text-light"></div></div>
<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}"><img src="{{ asset('assets/img/brand.png') }}" height="42" alt="Businos Line"></a>
        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav"><span class="navbar-toggler-icon"></span></button>
        <div id="nav" class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
                <li><a class="nav-link" href="{{ route('home') }}">{{ __('messages.home') }}</a></li>
                <li><a class="nav-link" href="{{ auth()->check() ? route('savings') : route('login') }}">{{ __('messages.savings') }}</a></li>
                <li><a class="nav-link" href="{{ auth()->check() ? route('gains') : route('login') }}">{{ __('messages.gains') }}</a></li>
                <li><a class="nav-link" href="{{ auth()->check() ? route('notifications') : route('login') }}">{{ __('messages.notifications') }}</a></li>
                <li><a class="nav-link" href="{{ route('about') }}">{{ __('messages.about') }}</a></li>
                <li class="dropdown"><a class="nav-link dropdown-toggle" data-bs-toggle="dropdown">{{ strtoupper(app()->getLocale()) }}</a><ul class="dropdown-menu">@foreach(['fr' => 'Français', 'en' => 'English', 'es' => 'Español'] as $code => $language)<li><a class="dropdown-item" href="{{ route('locale', $code) }}">{{ $language }}</a></li>@endforeach</ul></li>
                @auth<li><a class="btn btn-primary" href="{{ route('profile.edit') }}">{{ __('messages.account') }}</a></li>@else<li><a class="btn btn-primary" href="{{ route('login') }}">{{ __('messages.login') }}</a></li>@endauth
            </ul>
        </div>
    </div>
</nav>
@if(session('success'))<div class="container mt-3 alert alert-success">{{ session('success') }}</div>@endif
<main>@yield('content')</main>
<footer class="footer bg-light py-4"><div class="container"><div class="row text-center"><div class="col-md-6 text-md-start">© {{ now()->year }} Businos Line. {{ __('messages.rights') }}</div><div class="col-md-6 text-md-end mt-2 mt-md-0">Designed by <a href="https://team.xsamtech.com/xanderssamoth">Xanders Samoth</a></div></div></div></footer>
<script src="{{ asset('templates/admin/assets/vendor/libs/jquery/jquery.js') }}"></script>
<script src="{{ asset('templates/admin/assets/vendor/js/bootstrap.js') }}"></script>
<script src="{{ asset('assets/js/businos.js') }}"></script>
@stack('scripts')
</body>
</html>
