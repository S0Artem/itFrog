@vite(['resources/views/home/component/courses/courses.css'])

<section class="home__courses__section" id="home__courses">
    <div class="home__courses__contenteiner">
        <h2>У нас для каждого найдётся направление.</h2>
        <div class="card_conteiner" id="cardContainer">
            @foreach ($directions as $index => $direction)
                <div class="card {{ $index >= 6 ? 'hidden-card' : '' }}">
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
                    <a href="{{ route('direction.show', $direction->id) }}" class="card-arrow">
                        ➜
                    </a>
                </div>
            @endforeach
        </div>
        @if (count($directions) > 6)
            <a id="seeAllButton" class="btn">Записаться</a>
        @endif
    </div>
    <script>
document.addEventListener('DOMContentLoaded', function () {
    const cardContainer = document.getElementById('cardContainer');
    const seeAllButton = document.getElementById('seeAllButton');
    
    if (seeAllButton) {
        seeAllButton.addEventListener('click', function () {
            const hiddenCards = cardContainer.querySelectorAll('.hidden-card');
            if (cardContainer.classList.contains('show-all')) {
                // Hide cards with animation
                hiddenCards.forEach((card, index) => {
                    setTimeout(() => {
                        card.classList.remove('visible');
                        setTimeout(() => {
                            card.style.display = 'none';
                        }, 400); // Match transition duration
                    }, index * 100);
                });
                cardContainer.classList.remove('show-all');
                seeAllButton.textContent = 'Увидеть все';
            } else {
                // Show cards with animation
                cardContainer.classList.add('show-all');
                hiddenCards.forEach((card, index) => {
                    setTimeout(() => {
                        card.style.display = 'flex';
                        setTimeout(() => {
                            card.classList.add('visible');
                        }, 10);
                    }, index * 100);
                });
                seeAllButton.textContent = 'Скрыть';
            }
        });
    }
});
</script>
</section>

