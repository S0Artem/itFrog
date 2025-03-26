@vite(['resources/views/home/component/courses/courses.css'])

<section class="home__courses__section" id="home__courses">
    <div class="home__courses__contenteiner">
        <h2>У нас для каждого найдеться напровление</h2>
        <div class="card_conteiner">
            @foreach ($directions as $direction)
                <div class="card">
                    <div class="card-content">
                        <p class="courses-info">{{ $direction->modules_count }} МОДУЛЕЙ, {{ $direction->total_lessons }} ЗАНЯТИЯ</p>
                        <h2 class="card-title">{{ $direction->name }}</h2>
                        <ul class="card-list">
                            @foreach ($direction->moduls_to_display as $modul)
                                <li>
                                    {{ $modul->name }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="card-icon">
                        <img src="{{ asset($direction->icon) }}" alt="Logo" />
                    </div>
                    <button class="card-arrow" href="#">
                        ➜
                    </button>
                </div>
            @endforeach
        </div>
    </div>
</section>
