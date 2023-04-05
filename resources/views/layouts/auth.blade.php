<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @include('other.seo')
    <title>{{translate($gs->title)}}-@yield('title')</title>
    <link rel="stylesheet" href="{{asset('assets/frontend')}}/css/bootstrap.min.css" />
    {{-- <link href="{{asset('assets/frontend/css/main.php')}}?color={{$gs->theme_color}}" rel="stylesheet" /> --}}
    <link rel="shortcut icon" href="{{getPhoto($gs->favicon)}}">
</head>
<body>
@include('frontend.partials.header')

@yield('content')

@include('frontend.partials.footer')

<script src="{{asset('assets/frontend')}}/js/jquery-3.6.0.min.js"></script>
<script src="{{asset('assets/frontend')}}/js/bootstrap.min.js"></script>

@include('notify.alert')
@stack('script')
</body>

</html>
