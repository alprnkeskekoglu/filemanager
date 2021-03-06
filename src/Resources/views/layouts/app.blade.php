<!doctype html>
<html lang="{{ session('dawnstar.language.code') }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <title>Dawnstar - File Manager</title>
    <meta name="description" content="Dawnstar - FileManager">
    <meta name="robots" content="noindex, nofollow">
    <link rel="shortcut icon" href="assets/media/favicons/favicon.png">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="{{ dawnstarAsset('css/dashmix.min.css') }}">
    <link rel="stylesheet" href="{{ dawnstarAsset('css/xpro.min.css') }}">
    @stack('styles')
</head>
<body>
<div id="page-container" class="sidebar-o side-scroll page-header-fixed page-footer-fixed page-header-dark">
    @include('FileManagerView::layouts.sidebar')

    @yield('content')

    <script src="{{ dawnstarAsset('js/dashmix.core.min.js') }}"></script>
    <script src="{{ dawnstarAsset('js/dashmix.app.min.js') }}"></script>
    @stack('scripts')
</div>
</body>
</html>
