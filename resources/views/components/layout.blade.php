<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pageTitle ?? 'itFrog' }}</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo1.svg') }}">
    @vite('resources/css/app.css')
    @vite('resources/views/components/layout.css')
    @vite('resources/views/components/layout.js')

</head>
<body>
    <!-- Показываем прелоадер только на главной странице -->
    @if (Route::currentRouteName() === 'showeHome')
        <div id="preloader">
            <img src="{{ asset('img/logo.svg') }}" alt="Логотип">
        </div>

    @endif

    <header class="no-select">
        <div class="header">
            <div class="logo">
                <a href="{{ route('showeHome') }}"><img src="{{ asset('img/logo.svg') }}" alt="Logo" /></a>
            </div>
            <div class="burger-menu">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <ul class="header__ul">
                <li><a href="{{ route('showeHome') }}#home__form">Записаться</a></li>
                <li><a href="{{ route('showeHome') }}#home__courses">Курсы</a></li>
                <li><a href="{{ route('showeHome') }}#home__portfolio">Работы учеников</a></li>
                @if (!Auth::check())
                    <li><a href="{{ route('auth.showeLogin') }}">Вход</a></li>
                @else
                    <li><a href="{{ route('showeProfil') }}">{{ Auth::user()->name }}</a></li>
                    <li><a href="{{ route('auth.logout') }}">Выйти</a></li>
                    @if (Auth::user()->role === 'admin')
                        <li class="none"><a class="none" href="{{ route('showeAdminPortfolio') }}">Работы учеников</a></li>
                        <li class="none"><a class="none" href="{{ route('showeAdminApplication') }}">Заявки</a></li>
                        <li class="none"><a class="none" href="{{ route('admin.users.index') }}">Все Пользователи</a></li>
                        <li class="none"><a class="none" href="{{ route('showeRegisterUser') }}">Регистрация родителей</a></li>
                        <li class="none"><a class="none" href="{{ route('showeRegisterEmployee') }}">Регистрация сотрудника</a></li>
                        <li class="none"><a class="none" href="{{ route('showeRegisterStudent') }}">Регистрация ребёнка</a></li>
                        <li class="none"><a class="none" href="{{ route('showeShedule') }}">Группы</a></li>
                    @elseif (Auth::user()->role === 'teacher')
                        <li class="none"><a class="none" href="{{ route('showeTeacherPortfolio') }}">Работы учеников</a></li>
                        <li class="none"><a class="none" href="{{ route('showeSheduleTeacher') }}">Расписание</a></li>
                        <li class="none"><a class="none" href="{{ route('showCreateStudentProjectForm') }}">Создание работ учеников</a></li>
                    @endif
                @endif
            </ul>
        </div>
        @if (Auth::check() && Auth::user()->role === 'admin')
            <div class="header_admin">
                <div class="header_admin_content">
                    <a href="{{ route('showeAdminPortfolio') }}">Работы учеников</a>
                    <a href="{{ route('showeAdminApplication') }}">Заявки</a>
                    <a href="{{ route('admin.users.index') }}">Все пользователи</a>
                    <a href="{{ route('showeRegisterUser') }}">Регистрация родителей</a>
                    <a href="{{ route('showeRegisterEmployee') }}">Регистрация сотрудника</a>
                    <a href="{{ route('showeRegisterStudent') }}">Регистрация ученика</a>
                    <a href="{{ route('showeShedule') }}">Группы</a>
                </div>
            </div>
        @elseif (Auth::check() && Auth::user()->role === 'teacher')
            <div class="header_admin">
                <div class="header_admin_content">
                    <a href="{{ route('showeTeacherPortfolio') }}">Работы учеников</a>
                    <a href="{{ route('showeSheduleTeacher') }}">Расписание</a>
                    <a href="{{ route('showCreateStudentProjectForm') }}">Создание работ учеников</a>
                </div>
            </div>
        @endif
    </header>
    {{ $slot }}
    <footer>
        <div class="footer">
            <div class="footer__content">
                <div class="logo">
                    <a href="{{ route('showeHome') }}"><img src="{{ asset('img/logo.svg') }}" alt="Logo" class="footer-logo" /></a>
                </div>
                <div class="nav-wrapper">
                    <div class="nav">
                        <ul class="footer__ul">
                            <li><a href="{{ route('showeHome') }}#home__form">Записаться</a></li>
                            <li><a href="{{ route('showeHome') }}#home__courses">Курсы</a></li>
                            <li><a href="{{ route('showeHome') }}#home__portfolio">Работы учеников</a></li>
                        </ul>
                    </div>
                </div>
                <div class="footer__info">
                    <p>© 2025 itFrog. Все права защищены.</p>
                    <p><a href="mailto:support@itfrog.com">support@itfrog.com</a></p>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>