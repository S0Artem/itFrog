<x-layout>
@vite(['resources/views/admin/adminPortfolio/portfolio.css'])
@vite(['resources/views/admin/adminPortfolio/portfolio.js'])

<section class="home__portfolio__section">
    
    @if (Auth::user()->role === 'admin')
        <h2>Работы всех наших учеников</h2>
    @elseif(Auth::user()->role === 'teacher')
       <h2>Работы ваших учеников</h2> 
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="slider">
        <button class="prev">&#10094;</button> <!-- Левая стрелка -->
        <div class="slider-container">
            @foreach ($student_projects as $project)
                <div class="slide">
                    @if(Str::endsWith($project->video, ['.gif', '.png', '.jpg', '.jpeg', '.webp']))
                        <img src="{{ asset($project->video) }}" alt="GIF-анимация видеотчёта проекта ребёнка" class="video no-select">
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
                        <p>{{ $project->project }}</p>
                    </div>

                    <div class="edit-form-container">
                        <h4>Изменить проект</h4>
                        <form action="{{ Auth::user()->role === 'admin' ? route('studentProgectChange') : route('studentTeacherProgectChange') }}" method="post" class="studentProgectChangeForm">
                            @csrf
                            @method('PUT')

                            <input type="hidden" name="id" value="{{ $project->id }}">

                            {{-- Поиск студента с автоподсказками --}}
                            <div class="form-group">
                                <label for="student_search_{{ $project->id }}">Поиск ученика:</label>
                                <input type="text" id="student_search_{{ $project->id }}" class="form-control" placeholder="Начните вводить имя ученика..." value="{{ old('student_name', $selectedStudents[$project->student_id]->name ?? '') }}">
                                <input type="hidden" name="student_id" id="student_id_{{ $project->id }}" value="{{ old('student_id', $project->student_id) }}">
                                <div id="student_suggestions_{{ $project->id }}" class="suggestions"></div>
                            </div>

                            {{-- Описание проекта --}}
                            <div class="form-group">
                                <label for="text_{{ $project->id }}">Описание проекта:</label>
                                <textarea name="text" id="text_{{ $project->id }}" rows="3" class="form-control" required placeholder="Опишите проект ученика...">{{ old('text', $project->project) }}</textarea>
                            </div>

                            <button type="submit" class="btn">Обновить проект</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
        <button class="next">&#10095;</button> <!-- Правая стрелка -->
    </div>
    <script>
    // Получаем всех студентов для поиска
    const allStudents = @json($selectedStudents->values());
    
    document.addEventListener('DOMContentLoaded', function() {
        // Инициализируем поиск для каждого проекта
        @foreach ($student_projects as $project)
            initializeStudentSearch({{ $project->id }});
        @endforeach
    });

    function initializeStudentSearch(projectId) {
        const studentSearch = document.getElementById('student_search_' + projectId);
        const studentIdInput = document.getElementById('student_id_' + projectId);
        const studentSuggestions = document.getElementById('student_suggestions_' + projectId);

        if (!studentSearch || !studentIdInput || !studentSuggestions) return;

        // Обработка поиска студента
        studentSearch.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const filteredStudents = allStudents.filter(student => 
                student.name.toLowerCase().includes(searchTerm)
            );

            studentSuggestions.innerHTML = '';
            if (searchTerm.length > 0) {
                filteredStudents.forEach(student => {
                    const div = document.createElement('div');
                    div.className = 'suggestion-item';
                    div.textContent = student.name;
                    div.addEventListener('click', () => {
                        studentSearch.value = student.name;
                        studentIdInput.value = student.id;
                        studentSuggestions.innerHTML = '';
                    });
                    studentSuggestions.appendChild(div);
                });
            }
        });

        // Закрытие подсказок при клике вне поля поиска
        document.addEventListener('click', function(e) {
            if (!studentSearch.contains(e.target) && !studentSuggestions.contains(e.target)) {
                studentSuggestions.innerHTML = '';
            }
        });
    }
</script>
</section>



</x-layout>