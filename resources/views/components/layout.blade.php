<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel with Vite</title>
    @vite('resources/css/app.css')
    @vite('resources/views/components/layout.css')
    @vite('resources/views/components/layout.js')
</head>
<body>
    <header>
        <div class="header">
            <div class="logo">
                <a href="{{ route('showeHome') }}"><img src="{{ asset('img/logo.svg') }}" alt="Logo" /></a>
            </div>
            <ul class="header__ul">
                <li><a href="#">Записаться</a></li>
                <li><a href="#">Курсы</a></li>
                <li><a href="#">Преподователи</a></li>
                <li><a href="#">Отзывы</a></li>
            </ul>
            <ul class="header__ul">
                @if (!Auth::check())
                    <a href="{{ route('showeLogin') }}">Вход</a>
                @else
                    <a href="{{ route('logout') }}">Выйти</a>
                @endif
    
            </ul>
        </div>
        <div class="header_admin">
            <div class="header_admin_content">
                @if (Auth::check() && Auth::user()->role === 'admin')
                <a href="{{ route('showeAdminPortfolio') }}">Портфолио</a>
                <a href="{{ route('showeAdminAplication') }}">Заявки</a>
                <a href="{{ route('showeAdminRegister') }}">Регистрация</a>
                @endif
            </div>
        </div>
    </header>
    {{ $slot }}
</body>
</html>