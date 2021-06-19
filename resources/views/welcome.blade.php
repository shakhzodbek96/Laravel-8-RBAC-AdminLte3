<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@lang('panel.site_title')</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">

    <!-- Styles -->
    <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/bootstrap_my/my_style.css')}}">
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
<div class="wrapper flex-center position-ref full-height">
    @if (Route::has('login'))
        <div class="top-right links">
            @auth
                <div class="sl-nav" style="display: inline">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown">
                            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle link-black"><i class="fas fa-user"></i>
                                {{ auth()->user()->name }}
                            </a>
                            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow" style="left: 0px; right: inherit;">
                                <li>
                                    <a href="{{ route('userEdit',auth()->user()->id) }}" class="dropdown-item">
                                        <i class="fas fa-cogs"></i> @lang('global.settings')
                                    </a>
                                </li>
                                <li>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                    <a href="#" class="dropdown-item" role="button" onclick="
                                            event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt"></i> @lang('global.logout')
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            @endif
            @auth
                <a href="{{ url('/home') }}">@lang('global.home')</a>
            @else
                <a href="{{ route('login') }}">@lang('global.login')</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}">@lang('global.register')</a>
                @endif
            @endauth
        </div>
    @endif
    <div class="content">
        <div class="title m-b-md">
            @lang('panel.site_title')
        </div>

    </div>
</div>
</body>
</html>

<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<script>
    $(window).on('load', function() {
        $(".loader-in").fadeOut();
        $(".loader").delay(150).fadeOut("fast");
        $(".wrapper").fadeIn("fast");
        $("#app").fadeIn("fast");
    });
</script>
