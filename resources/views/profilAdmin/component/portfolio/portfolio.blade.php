<!-- Подключаем Swiper.js -->
@vite(['resources/views/profilAdmin/component/portfolio/portfolio.css'])
@vite(['resources/views/profilAdmin/component/portfolio/portfolio.js'])

<section class="home__portfolio__section">
    <h2>Портфолио наших студентов</h2>
    <div class="slider">
        <button class="prev">&#10094;</button> <!-- Левая стрелка -->
        <div class="slider-container">
            @foreach ($student_projects as $project)
                <div class="slide">
                    @if(Str::endsWith($project->video, '.gif'))
                        <img src="{{ asset($project->video) }}" alt="GIF-анимация" class="video">
                    @else
                        <video src="{{ asset($project->video) }}" controls></video>
                    @endif
                    <div class="portfolio__info">
                        <div class="portfolio__tags">
                            <span class="tag yellow">{{ $project->id }}</span>
                            @foreach ($project->tags as $tag)
                                <span class="tag yellow">{{ $tag }}</span>
                            @endforeach
                            <span class="tag yellow">{{ $project->student_age }}</span>
                        </div>
                        <h3>{{ $project->student_name }}</h3>
                        <p>{{ $project->progect }}</p>
                    </div>




                    <h1>Изменить проект</h1>
                    <form action="{{ route('studentProgectChange') }}" method="post" class="studentProgectChangeForm">
                        @csrf
                        @method('PUT') <!-- Используем PUT для обновления -->

                        <!-- ID проекта (если нужно) -->
                        <input type="hidden" name="id" value="{{ $project->id }}">

                        <!-- Поле с выпадающим списком -->
                        <label for="student">Выберите ребенка:</label>
                        <div class="form-group">
                            <select name="student_id" id="student" class="form-select">
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}" data-age="{{ $student->age }}" {{ old('student_id', $project->student_id) == $student->id ? 'selected' : '' }}>
                                        {{ $student->name }}, {{ $student->age }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Текст о проекте -->
                        <label for="text" class="form-label">Описание проекта:</label>
                        <div class="form-group">
                            <textarea name="text" id="text" class="form-input" placeholder="Техт про проект" rows="2">{{ old('text', $project->progect) }}</textarea>
                        </div>
                        @error('text') 
                            <p class="error text-danger">{{ $message }}</p>
                        @enderror

                        <button type="submit" class="btn btn-primary mt-3">Изменить</button>
                    </form>




                </div>
            @endforeach
        </div>
        <button class="next">&#10095;</button> <!-- Правая стрелка -->
    </div>
</section>

