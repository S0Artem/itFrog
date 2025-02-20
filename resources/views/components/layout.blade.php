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
    <header class="header">
        <div class="logo">
            <a href="#"><img src="{{ asset('img/logo.svg') }}" alt="Logo" /></a>
        </div>
        <ul class="header__ul">
            <li>Записаться</li>
            <li>Курсы</li>
            <li>Преподователи</li>
            <li>Отзывы</li>
        </ul>
        <ul class="header__ul">
            <div class="dropdown" id="dropdown">
                <div class="dropdown__address" id="dropdown__address">
                    <span>Набережные Челны</span>
                </div>
                <ul class="dropdown__menu" id="dropdown__menu">
                    <li class="dropdown__menu__item" id="Kazan">Казань</li>
                    <li class="dropdown__menu__item" id="Novosibirsk">Новосибирск</li>
                    <li class="dropdown__menu__item" id="Moskow">Москва</li>
                </ul>
            </div>
            <li>Вход</li>
        </ul>
    </header>
    {{ $slot }}
</body>
</html>