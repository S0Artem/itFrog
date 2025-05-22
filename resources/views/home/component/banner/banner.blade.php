@vite(['resources/views/home/component/banner/banner.css'])

<section class="home__banner__section">
    <div class="home__banner__contenteiner">
        <div class="home__banner__content">
            <div class="home__banner__content__text">
                <h2>Какое направление будет интересно вашему ребенку?</h2>
                <p>Оставте заявку и администратор подберет курс под вас</p>
                <a href="#home__form" class="btn">Записаться</a>
            </div>
            <img src="{{ asset('img/frog.png') }}" alt="Logo" />
        </div>
    </div>
</section>
