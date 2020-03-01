<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>{{config('diisquare.title')}}</title>

    <!-- <link rel="icon" href="{{asset('image/mylogo.jpg')}}">
    <link rel="apple-touch-icon" href="{{asset('image/mylogo.jpg')}}"> -->
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    @yield('styles')

</head>
<body>
{{-- Navigation Bar--}}
@include('modules.navbar')


<main>
    @yield('content')
</main>


<div class="container">
    <div class="row">
        <ul class="fa-ul">
            <li><i class="fa-li fa fa-link"></i>
                Powered by
                <a href="https://laravel.com/" target="_blank">
                    Laravel
                </a>
            </li>
            <li><i class="fa-li fa fa-copyright"></i>
                Copyright DII-web Group All Rights Reserved.
            </li>
            <li><i class="fa-li fa fa-cc"></i>
                <a rel="license" href="http://creativecommons.org/licenses/by/4.0/">
                    CC BY-NC 4.0
                </a>
            </li>
        </ul>
    </div>
</div>
<script src="{{asset('js/app.js')}}"></script>

@yield('scripts')

</body>
</html>
