<!doctype html>
<html lang="fr" class="light-style layout-menu-fixed">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title','Administration') — Businos Line</title>
    <link rel="icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" sizes="any">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/favicon/favicon-16x16.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/img/favicon/apple-touch-icon.png') }}">
    <link rel="stylesheet" href="{{ asset('templates/admin/assets/vendor/fonts/boxicons.css') }}"><link rel="stylesheet" href="{{ asset('templates/admin/assets/vendor/css/core.css') }}"><link rel="stylesheet" href="{{ asset('templates/admin/assets/vendor/css/theme-default.css') }}"><link rel="stylesheet" href="{{ asset('templates/admin/assets/css/demo.css') }}"><link rel="stylesheet" href="{{ asset('assets/css/businos.css') }}">
</head>
<body>
<div id="ajax-loader" class="ajax-loader d-none"><div class="spinner-border text-light"></div></div>
<div class="layout-wrapper layout-content-navbar"><div class="layout-container">
<aside class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo"><a class="app-brand-link" href="{{ route('admin.dashboard') }}"><img src="{{ asset('assets/img/brand.png') }}" height="44" alt="Businos Line"></a></div>
    <ul class="menu-inner py-1">@foreach([['admin.dashboard','bx-home-circle','Tableau de bord'],['admin.roles','bx-shield','Rôles'],['admin.users','bx-user','Utilisateurs'],['admin.savings','bx-wallet','Épargnes'],['admin.gains','bx-trophy','Gains'],['admin.abouts','bx-info-circle','Infos légales']] as $item)<li class="menu-item {{ request()->routeIs($item[0].'*') ? 'active' : '' }}"><a class="menu-link" href="{{ route($item[0]) }}"><i class="menu-icon tf-icons bx {{ $item[1] }}"></i><div>{{ $item[2] }}</div></a></li>@endforeach</ul>
</aside>
<div class="layout-page">
    <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached bg-navbar-theme"><div class="navbar-nav align-items-center w-100"><div class="nav-item d-flex align-items-center position-relative flex-grow-1"><i class="bx bx-search fs-4"></i><input id="admin-search" data-url="{{ route('admin.search') }}" class="form-control border-0 shadow-none" placeholder="Rechercher utilisateur, rôle, titre…"><div id="search-results" class="autocomplete-results list-group shadow"></div></div><a href="{{ route('profile.edit') }}" class="btn btn-sm btn-outline-primary">{{ auth()->user()->firstname ?: auth()->user()->email }}</a></div></nav>
    <div class="content-wrapper"><div class="container-xxl flex-grow-1 container-p-y">@yield('content')</div><footer class="content-footer footer bg-footer-theme"><div class="container-xxl d-flex flex-column flex-md-row justify-content-between py-3 text-center"><span>© {{ now()->year }} Businos Line</span><span>Designed by <a href="https://team.xsamtech.com/xanderssamoth">Xanders Samoth</a></span></div></footer></div>
</div></div></div>
<script src="{{ asset('templates/admin/assets/vendor/libs/jquery/jquery.js') }}"></script><script src="{{ asset('templates/admin/assets/vendor/js/bootstrap.js') }}"></script><script src="{{ asset('templates/admin/assets/vendor/js/menu.js') }}"></script><script src="{{ asset('templates/admin/assets/js/main.js') }}"></script><script src="{{ asset('assets/js/businos.js') }}"></script>
</body></html>
