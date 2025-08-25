<x-layout>
    @vite(['resources/views/directions/show.css'])
    
    <section class="direction__section" id="direction__main">
        <div class="direction__container">
            <!-- Заголовок направления -->
            <div class="direction__header">
                <div class="direction__header_content">
                    <div class="direction__icon">
                        <img src="{{ asset($direction->icon) }}" alt="{{ $direction->name }}" />
                    </div>
                    <div class="direction__header_text">
                        <h1>{{ $direction->name }}</h1>
                        <p class="direction__description">{{ $direction->description }}</p>
                    </div>
                </div>
                <a href="{{ route('showeHome') }}#home__courses" class="back__btn">
                    ← Назад к направлениям
                </a>
            </div>

            <!-- Подробное описание -->
            @if($direction->detailed_description)
                <div class="direction__detailed">
                    <h2>О направлении</h2>
                    <p>{{ $direction->detailed_description }}</p>
                </div>
            @endif

            <!-- Модули обучения -->
            <div class="direction__modules">
                <h2>Модули обучения</h2>
                <div class="modules__grid">
                    @foreach($direction->moduls as $index => $modul)
                        <div class="module__card" @auth @if(Auth::user()->role !== 'teacher') style="cursor: pointer;" @endif @else style="cursor: pointer;" @endauth>
                            <div class="module__header">
                                <h3>Модуль {{ $index + 1 }}</h3>
                                <span class="module__lessons">{{ $modul->lesson }} занятий</span>
                            </div>
                            
                            <h4 class="module__title">{{ $modul->name }}</h4>
                            
                            @if($modul->description)
                                <p class="module__description">{{ $modul->description }}</p>
                            @endif
                            
                            @if($modul->detailed_description)
                                <div class="module__detailed">
                                    <p>{{ $modul->detailed_description }}</p>
                                </div>
                            @endif
                            
                            @if($modul->tags)
                                <div class="module__tags">
                                    @foreach(json_decode($modul->tags, true) as $tag)
                                        <span class="module__tag">{{ $tag }}</span>
                                    @endforeach
                                </div>
                            @endif
                            
                            @auth
                                @if(Auth::user()->role === 'teacher')
                                    <div class="module__teacher-actions">
                                        @if($modul->file)
                                            <a href="{{ asset($modul->file) }}" 
                                               download="{{ $modul->name }} для учителя.pdf" 
                                               class="module__download-btn">
                                                📄 Скачать материалы модуля
                                            </a>
                                        @else
                                            <p class="module__no-file">Материалы для этого модуля пока не загружены.</p>
                                        @endif
                                    </div>
                                @endif
                            @endauth
                        </div>
                    @endforeach
                </div>
            </div>
            
            <div id="direction-form">
                @include('home.component.form.form')
            </div>
        </div>
        <script>
        // Передаем данные с сервера в JavaScript
        const userRole = @json(auth()->check() ? auth()->user()->role : null);
        
        function scrollToForm() {
            const form = document.getElementById('direction-form');
            if (form) {
                form.scrollIntoView({ 
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        }
        
        // Обработчик клика для карточек модулей (только для не-учителей)
        document.addEventListener('DOMContentLoaded', function() {
            const moduleCards = document.querySelectorAll('.module__card');
            
            moduleCards.forEach(function(card) {
                card.addEventListener('click', function(e) {
                    // Проверяем, является ли пользователь учителем
                    if (userRole !== 'teacher') {
                        // Для не-учителей - переходим к форме
                        scrollToForm();
                    }
                    // Для учителей ничего не делаем - они используют ссылку
                });
            });
        });
    </script>
    </section>

    
</x-layout> 