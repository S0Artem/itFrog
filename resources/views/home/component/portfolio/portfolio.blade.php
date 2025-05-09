<!-- Подключаем Swiper.js -->
@vite(['resources/views/home/component/portfolio/portfolio.css'])
@vite(['resources/views/home/component/portfolio/portfolio.js'])

<section class="home__portfolio__section" id="home__portfolio">
    <h2>Работы наших студентов</h2>
    <div class="slider">
        <button class="prev no-select">&#10094;</button> <!-- Левая стрелка -->
        <div class="slider-container">
            @foreach ($student_projects as $project)
                <div class="slide">
                    @if(Str::endsWith($project->video, ['.gif', '.png', '.jpg', '.jpeg', '.webp']))
                        <img src="{{ asset($project->video) }}" alt="GIF-анимация видеотчета проекта ребенка" class="video no-select">
                    @else
                        <video src="{{ asset($project->video) }}" controls class="no-select"></video>
                    @endif
                    <div class="portfolio__info">
                        <div class="portfolio__tags no-select">
                            @foreach ($project->tags as $tag)
                                <span class="tag yellow">{{ $tag }}</span>
                            @endforeach
                            <span class="tag yellow">{{ $project->student_age }} лет</span>
                        </div>
                        <h3>{{ $project->student_name }}</h3>
                        <p>{{ $project->progect }}</p>
                    </div>
                </div>
            @endforeach
        </div>
        <button class="next no-select">&#10095;</button> <!-- Правая стрелка -->
    </div>
</section>

