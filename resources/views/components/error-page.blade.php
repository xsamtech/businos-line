@props(['code', 'title', 'message'])
<!doctype html>
<html lang="{{ app()->getLocale() }}" class="light-style">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>{{ $code }} — Businos Line</title>
    <link rel="icon" href="{{ asset('assets/img/favicon/favicon.ico') }}"><link rel="stylesheet" href="{{ asset('templates/admin/assets/vendor/fonts/boxicons.css') }}"><link rel="stylesheet" href="{{ asset('templates/admin/assets/vendor/css/core.css') }}"><link rel="stylesheet" href="{{ asset('templates/admin/assets/vendor/css/theme-default.css') }}"><link rel="stylesheet" href="{{ asset('templates/admin/assets/vendor/css/pages/page-misc.css') }}">
</head>
<body><div class="container-xxl container-p-y"><div class="misc-wrapper text-center"><h1 class="mb-2 mx-2">{{ $title }}</h1><p class="mb-4 mx-2">{{ $message }}</p><div class="display-1 fw-bold text-primary mb-4">{{ $code }}</div><a href="{{ route('home') }}" class="btn btn-primary"><i class="bx bx-home-alt me-1"></i>{{ __('messages.home') }}</a><div class="mt-4"><img src="{{ asset('templates/admin/assets/img/illustrations/page-misc-error-light.png') }}" alt="{{ $code }}" width="500" class="img-fluid"></div></div></div><script src="{{ asset('templates/admin/assets/vendor/js/helpers.js') }}"></script></body>
</html>
