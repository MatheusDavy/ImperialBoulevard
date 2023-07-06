<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <!----------------------- LIBRARY ---------------->
    <!-- Swiper Slider -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

    <!-- Gsap -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    
    <!-- Font-Awesome - ICONS -->
    <script src="https://kit.fontawesome.com/739b481bf0.js" crossorigin="anonymous"></script>

    @if (isset($gtm) && $gtm)
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                `https://www.googletagmanager.com/gtm.js?id=` + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', '{{$gtm}}');
    </script>
    @endif

    @if (isset($metas))
    @foreach ($metas as $key => $meta)
    <meta name="{{ $key }}" property="{{ $key }}" content="{{ $meta }}" />
    @endforeach
    <title>{{ $main_title }}{{ isset($title) && $title? ' - '.$title : '' }}</title>
    @endif

    <link rel="shortcut icon" href="{{ asset('site/img/favicon.ico') }}" />
    <input hidden type="text" id="recaptcha" value="{{$recaptcha}}">

    <link href="{{ asset(mix('site/css/vendor.css')) }}" rel="stylesheet">
    <link href="{{ asset('site/css/main.css') }}" rel="stylesheet">
    <link href="{{ asset(mix('site/css/plugins/cropper.css')) }}" rel="stylesheet">

    

</head>

<body class="app">
    @if (isset($gtm) && $gtm)
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{$gtm}}" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    @endif
    <div class='fail-message'></div>
    <div class='success-message'></div>

    @include('site.components.zoom_modal')

    @include('site.layout.header')
    <main id="main">
        @php
        $route = Route::current();
        $routeName = $route->getName();
        try {
        $routeCurrent = route($routeName, $routeParams);
        } catch (\Throwable $th) {
        $routeCurrent = route('site.home');
        }
        @endphp
        <input hidden id="routeCurrent" value="{{$routeCurrent}}">
        <input hidden id="langFunction" value="{{route('site.changeLang')}}">
        @yield('content')
    </main>
    @include('site.layout.footer')
    @if (isset($rd) && $rd)
    <script type="text/javascript" async src="{{$rd}}"></script>
    @endif
    <script src="{{ asset(mix('site/js/vendor.js')) }}"></script>
    <script src="{{ asset(mix('site/js/main.js')) }}"></script>
    <script src="https://www.google.com/recaptcha/api.js?render={{$recaptcha}}"></script>
    @yield('js')
</body>

</html>