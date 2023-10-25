<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no,  maximum-scale=1.0">
    <!-- theme style switch -->
    <meta name="theme-style-mode" content="1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title inertia>{{ Config::get('seotools.site_name', env('APP_NAME')) }}</title>
   
    <meta name="description" itemprop="description" inertia content="{{ Config::get('seotools.metaDescription') }}"/>
    <meta name="keywords" inertia content="{{ Config::get('seotools.keyWords') }}" /> 
    <meta property="og:description" inertia content="{{ Config::get('seotools.metaDescription') }}" />
    <meta property="og:title" inertia content="{{ Config::get('seotools.site_name') }}" />
    <meta property="og:url" inertia content="{{ Config::get('seotools.current_url') }}" />
    
    <meta property="og:site_name" inertia content="{{ Config::get('seotools.site_name') }}" />
    <meta property="og:image"  inertia content="{{ Config::get('seotools.metaImage') }}" />
    <meta property="og:image:url"  inertia content="{{ Config::get('seotools.metaImage') }}" />
  
    <meta name="twitter:card" inertia content="{{ Config::get('seotools.metaDescription') }}" />
    <meta name="twitter:title" inertia content="{{ Config::get('seotools.site_name') }}" />
    <!-- Favicon -->
    <link rel="icon" href="{{ asset(get_option('primary_data',true)->favicon ?? '') }}" type="image/png">
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
    <!-- CSS here -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/css/meanmenu.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/css/backtotop.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/css/nice-select.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome-pro.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/css/elegant-icon.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/css/spacing.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css?v=10') }}" type="text/css">
    @vite('resources/js/app.js')
    @inertiaHead
   
</head>

<body class="active-dark-mode">
    @routes
    @inertia
    <!-- JS here -->
    <script src="{{ asset('assets/js/vendor/jquery.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/waypoints.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-bundle.js') }}"></script>
    <script src="{{ asset('assets/js/cookie.js') }}"></script>
    <script src="{{ asset('assets/js/style-switcher.js') }}"></script>
    <script src="{{ asset('assets/js/meanmenu.js') }}"></script>
    <script src="{{ asset('assets/js/parallax.js') }}"></script>
    <script src="{{ asset('assets/js/backtotop.js') }}"></script>
    <script src="{{ asset('assets/js/nice-select.js') }}"></script>
    <script src="{{ asset('assets/js/wow.js') }}"></script>
    <script src="{{ asset('assets/js/imagesloaded-pkgd.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>

</body>
</html>