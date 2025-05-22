<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>itFrog</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo1.svg') }}">
    @vite('resources/css/app.css')
    @vite('resources/views/components/layout.css')
</head>
<body>
    <header class="no-select">
        <div class="header">
            <div class="logo">
                <a href="{{ route('showeHome') }}"><img src="{{ asset('img/logo.svg') }}" alt="Logo" /></a>
            </div>
            <ul class="header__ul">
                <li><a href="{{ route('showeHome') }}#home__form">Записаться</a></li>
                <li><a href="{{ route('showeHome') }}#home__courses">Курсы</a></li>
                <li><a href="{{ route('showeHome') }}#home__portfolio">Работы студентов</a></li>
            </ul>
            <ul class="header__ul">
                @if (!Auth::check())
                    <a href="{{ route('showeLogin') }}">Вход</a>
                @else
                    <a href="{{ route('showeProfil') }}">{{ Auth::user()->name }}</a>
                    <a href="{{ route('logout') }}">Выйти</a>
                @endif
    
            </ul>
        </div>
        @if (Auth::check() && Auth::user()->role === 'admin')
        <div class="header_admin">
            <div class="header_admin_content">
                
                <a href="{{ route('showeAdminPortfolio') }}">Работы студентов</a>
                <a href="{{ route('showeAdminAplication') }}">Заявки</a>
                <a href="{{ route('showeRegisterUser') }}">Регистрация родитетеля</a>
                <a href="{{ route('showeRegisterEmployee') }}">Регистрация сотрудника</a>
                <a href="{{ route('showeRegisterStudent') }}">Регистрация ребенка</a>
                <a href="{{ route('showeShedule') }}">Группы</a>
            </div>
        </div>
        @elseif (Auth::check() && Auth::user()->role === 'teacher')
        <div class="header_admin">
            <div class="header_admin_content">
                <a href="{{ route('showeSheduleTeacher') }}">Расписание</a>
                <a href="{{ route('cashPaymen.showe') }}">Оплата наличными</a>
            </div>
        </div>
        @endif
    </header>
    {{ $slot }}
</body>
</html>