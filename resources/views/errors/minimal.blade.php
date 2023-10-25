<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no,  maximum-scale=1.0">
    <!-- theme style switch -->
    <meta name="theme-style-mode" content="1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('code')</title>
    <!-- Favicon -->
    <link rel="icon" href="{{ asset(get_option('primary_data',true)->favicon ?? '') }}" type="image/png">
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
    <!-- CSS here -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}" type="text/css">
   
    <link rel="stylesheet" href="{{ asset('assets/css/spacing.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" type="text/css">
   </head>
   <body>
      <!--[if lte IE 9]>
      <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
      <![endif]-->
      <main>
       <!-- 404 area start -->
         <section class="error__area pt-100 pb-100">
            <div class="container">
               <div class="row justify-content-center">
                  <div class="col-lg-6 col-md-10">
                     <div class="error__content text-center">
                        <div class="error__thumb m-img mb-20">
                           @yield('image')
                           
                        </div>
                        <div class="error__content">
                           <h2 class="error__title">@yield('code')</h2>
                           <h4>@yield('message')</h4>
                          
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>
         <!-- 404 area end -->         
      </main>    
    <script src="{{ asset('assets/js/vendor/jquery.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-bundle.js') }}"></script>
    <script src="{{ asset('assets/js/cookie.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
   </body>
</html>
