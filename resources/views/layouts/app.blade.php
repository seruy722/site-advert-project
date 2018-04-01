<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <script
  src="https://code.jquery.com/jquery-2.2.4.min.js"
  integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
  crossorigin="anonymous"></script>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    {{--  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">  --}}
    <style>
    .logo{
        width: 50px;
    }
    .stars{
        color: red;
    }
    textarea{
        resize: vertical;
    }
    .main_foto{
        height: 150px;
    }
    .paging{
        text-align: center;
    }
    .main_row{
        padding: 10px;
        border-top: 1px solid gray;
        border-color: #F0F0F0;
    }
    .foto{
        background-color: #F7F7F7;
        text-align: center;
    }
    .price{
        text-align: right;
        font-size: 20px;
        font-weight: bold;
        color: #3F4C52;
    }
    .grey{
        color: #B4BBCE;
    }
    .title{
        font-weight: bold;
        text-decoration: none;
    }
    .region{
        font-weight: bold;
        color: #909090;
    }
    .middle_block{
        display: flex;
        flex-direction: column;
       align-content: flex-start;
    }
    .mr-sm-2{
        width: 80% !important;
    }
    .search_block{
        display: flex;
        border-radius: 8px;
        height: 70px;
        background-color: #0098D0;
    }
    .search_block>div{
        height: 40px;
        margin: auto;
        width: 500px;
    }
    .rubrics{
        margin-top: 20px;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
        list-style: none;
    }
    .rubrics>li{
        width: 200px;
        height: 40px;
        margin-right: 50px;
    }
    .navbar{
        background-color: #F7F7F7;
    }
    .view_block{
        background-color: #F7F7F7;
        border: 2px solid #EFEFEFed;
    }
    .comment{
        background-color: #EFEFEFed;
        padding: 15px;
        border-radius: 8px;
        border: 2px solid #EFEFEFed;
    }
    .comment_date{
        font-size: 12px;
        color: #888888;
    }
    .advert_info{
        color: #888888;
    }
    .advert_description{
        font-size: 16px;
    }
    .advert{
        background-color: #fff;
        padding: 15px;
    }
    .advert_image_view{
        text-align: center;
    }
    .advert_image_view>img{
        width: 300px;
    }
    .rubrics_btn{
        margin-top: 15px;
    }
    .view_img{
        width: 220px;
    }
    .advert_info1{
        display: flex;
        justify-content: space-around;
        font-size: 18px;
        text-align: center;
    }
    .advert_info1>div{
        width: 300px;
        background-color: #0098D0;
        height: 35px;
        color: #fff;
        font-weight: bold;
        border-radius: 8px;
        padding: 5px;
    }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{asset('images/logo.jpg') }}" alt="logo" class="logo">
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Войти</a></li>
                            <li><a href="{{ route('register') }}">Регистрация</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>
                                @if (Auth::user()->role==='admin')
                                <ul class="dropdown-menu" role="menu">
                                        <li><a href="{{route('accounts.admin.home',Auth::id())}}">Мой профиль</a></li>
                                        <li><a href="{{route('accounts.admin.users')}}">Пользователи</a></li>
                                        <li class="{{ (Route::currentRouteName() == 'accounts.admin.blokedList') ? 'active' : '' }}"><a href="{{route('accounts.admin.blokedList')}}">Черный список</a></li>
                                        <li class="{{ (Route::currentRouteName() == 'accounts.admin.rubrics') ? 'active' : '' }}"><a href="{{route('accounts.admin.rubrics')}}">Рубрики</a></li>
                                        <li><a href="{{route('accounts.admin.settings',Auth::id())}}">Настройки</a></li>
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Выйти
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                
                                </ul> 
                                @else
                                <ul class="dropdown-menu" role="menu">
                                        <li><a href="{{route('accounts.user.home',Auth::id())}}">Мой профиль</a></li>
                                        <li><a href="{{route('accounts.user.settings',Auth::id())}}">Настройки</a></li>
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Выйти
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                
                                </ul>
                                @endif

                            </li>
                            <li><a href="{{route('create')}}" class="btn btn-warning">+ СОЗДАТЬ ОБЬЯВЛЕНИЕ</a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
        @yield('userControlMenu')
        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script>
        $("#btn").click(function () {

            $('.add_input').append(
               "<tr><td ><input type='text' name='rubrics[]' class='form-control'></td></tr>"
            );
            // $('p').appendTo(
            //    '.td'
            // );

    });

    </script>
</body>
</html>
