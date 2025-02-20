@vite(['resources/views/home/component/main/main.css'])

<section class="home__main__section">
    <div class="home__main__content">
        <div class="home__main__content_text">
            <h1>Школа программирования<br>для детей и подростков itFrog’</h1>
            <p>Запишите своего ребенка на бесплатный пробный урок<br>и погрузите его в сферу it</p>
        </div>
        <div class="home__main__content__banner">
            <img src="{{ asset('img/icon_stud.png') }}" alt="Logo" />
            // TODO: ты точно хочешь, чтобы Голубева видела в твоей вёрстке br?
            <p>2 000<br>учеников</p>
            <img src="{{ asset('img/icon_stud.png') }}" alt="Logo" />
            <p>2 000<br>учеников</p>
            <img src="{{ asset('img/icon_stud.png') }}" alt="Logo" />
            <p>2 000<br>учеников</p>
        </div>
        <div class="home__main__content__banner home__main__content__banner2">
            <img src="{{ asset('img/icon_stud.png') }}" alt="Logo" />
            <p>2 000<br>учеников</p>
            <img src="{{ asset('img/icon_stud.png') }}" alt="Logo" />
            <p>2 000<br>учеников</p>
            <img src="{{ asset('img/icon_stud.png') }}" alt="Logo" />
            <p>2 000<br>учеников</p>
        </div>
        <button class="btn">
            Записаться
        </button>
    </div>
</section>
