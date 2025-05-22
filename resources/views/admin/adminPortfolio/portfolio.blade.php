<x-layout>
@vite(['resources/views/admin/adminPortfolio/portfolio.css'])
@vite(['resources/views/admin/adminPortfolio/portfolio.js'])

<section class="home__portfolio__section">
    
    <h2>Работы наших студентов</h2>
    <div class="slider">
        <button class="prev">&#10094;</button> <!-- Левая стрелка -->
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




                    <h1>Изменить проект</h1>
                    <form action="{{ route('studentProgectChange') }}" method="post" class="studentProgectChangeForm">
                        @csrf
                        @method('PUT') <!-- Используем PUT для обновления -->

                        <!-- ID проекта (если нужно) -->
                        <input type="hidden" name="id" value="{{ $project->id }}">

                        <!-- Поле с выпадающим списком -->
                        <label for="student">Выберите ребенка:</label>
                        <div class="form-group center-select">
                            @php
                                $selectedStudent = $selectedStudents[$project->student_id] ?? null;
                            @endphp

                            <select name="student_id"
                                    class="form-select"
                                    data-url="{{ route('students.search') }}"
                                    data-selected-id="{{ $selectedStudent->id ?? '' }}"
                                    data-selected-label="{{ $selectedStudent ? $selectedStudent->name . ', ' . \Carbon\Carbon::parse($selectedStudent->birthdate)->age . ' лет' : '' }}">
                            </select>

                        </div>
                        @error('student_id')<p class="error">{{ $message }}</p>@enderror
                        <!-- Текст о проекте -->
                        <label for="text" class="form-label">Описание проекта:</label>
                        <div class="form-group">
                            <textarea name="text" id="text" class="form-input" placeholder="Техт про проект" rows="2">{{ old('text', $project->progect) }}</textarea>
                        </div>
                        @error('text')<p class="error">{{ $message }}</p>@enderror

                        <button type="submit" class="btn btn-primary mt-3">Изменить</button>
                    </form>




                </div>
            @endforeach
        </div>
        <button class="next">&#10095;</button> <!-- Правая стрелка -->
    </div>
</section>


</x-layout>