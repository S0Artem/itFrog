@vite(['resources/views/home/component/main/main.css'])

<section class="home__main__section" id="home__main">
    <div class="home__main__content">
        <div class="home__main__content_text">
            @if (session('login'))
                <div class="alert alert-login">
                    {{ session('login') }}
                </div>
            @endif
            <h1>Школа программирования для детей и подростков itFrog’</h1>
            <p>Запишите своего ребенка на бесплатный пробный урок и погрузите его в сферу it</p>
        </div>
        <div class='home__main__content__baner__btn'>
            <div class="home__main__content__banner no-select">
                <img src="{{ asset('img/icon_stud.png') }}" alt="Logo" />
                <div class="home__main__content__banner__text">
                    <p>более 2 000 учеников</p>
                </div>
                <img src="{{ asset('img/icon_stud.png') }}" alt="Logo" />
                <div class="home__main__content__banner__text">
                    <p>более 800 отзывов</p>
                </div>
                <img src="{{ asset('img/icon_stud.png') }}" alt="Logo" />
                <div class="home__main__content__banner__text">
                    <p>4.6 оценка на 2ГИС</p>
                </div>
            </div>
            <div class="home__main__content__banner no-select home__main__content__banner2">
                <img src="{{ asset('img/icon_stud.png') }}" alt="Logo" />
                <div class="home__main__content__banner__text">
                    <p>более 200 модулей</p>
                </div>
                <img src="{{ asset('img/icon_stud.png') }}" alt="Logo" />
                <div class="home__main__content__banner__text">
                    <p>более 5000 уроков</p>
                </div>
                <img src="{{ asset('img/icon_stud.png') }}" alt="Logo" />
                <div class="home__main__content__banner__text">
                    <p>более 300 учителей</p>
                </div>
                
            </div>
            <a class="btn" href="#home__form">
                Записаться
            </a>
        </div>
    </div>
</section>
