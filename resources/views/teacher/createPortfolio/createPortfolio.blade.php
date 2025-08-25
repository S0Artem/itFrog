<x-layout>
    @vite(['resources/views/teacher/createPortfolio/createPortfolio.css'])
    @vite(['resources/views/teacher/createPortfolio/createPortfolio.js'])
    <section class="register__section">
        <div class="register__contenteiner">
            <div class="register-container">
                <h2>Создание проекта ученика</h2>

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

                <form action="{{ route('portfolio.store') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    {{-- Поиск ученика с автоподсказками --}}
                    <div class="form-group">
                        <label for="student_search">Поиск ученика:</label>
                        <input type="text" id="student_search" class="form-control" placeholder="Начните вводить имя ученика..." value="{{ old('student_name') }}">
                        <input type="hidden" name="student_id" id="student_id" value="{{ old('student_id') }}">
                        <div id="student_suggestions" class="suggestions"></div>
                    </div>

                    {{-- Информация о модуле (автоматически заполняется) --}}
                    <div class="form-group">
                        <label>Модуль:</label>
                        <div id="modul_info" class="modul-info">
                            @if(old('modul_name'))
                                {{ old('modul_name') }}
                            @else
                                Выберите ученика для отображения модуля.
                            @endif
                        </div>
                        <input type="hidden" name="modul_id" id="modul_id" value="{{ old('modul_id') }}">
                        <input type="hidden" name="modul_name" id="modul_name" value="{{ old('modul_name') }}">
                    </div>

                    {{-- Загрузка медиафайла с предпросмотром --}}
                    <div class="form-group">
                        <label>Загрузите фото или видео:</label>
                        <div class="file-upload">
                            <label class="file-upload-label">
                                <i class="fas fa-cloud-upload-alt"></i>
                                Перетащите файл сюда или нажмите для выбора
                                <small class="form-text">Максимальный размер: 1 МБ, разрешение: 768×432</small>
                            </label>
                            <input type="file" name="media" id="media" accept="image/jpeg,image/png,image/jpg,video/mp4" required>
                        </div>
                        <div id="media_preview" class="media-preview">
                            @if(old('media_preview'))
                                <img src="{{ old('media_preview') }}" alt="Предпросмотр" style="max-width: 100%; height: auto;">
                            @endif
                        </div>
                        @error('media') <p class="error">{{ $message }}</p> @enderror
                    </div>

                    {{-- Описание проекта --}}
                    <div class="form-group">
                        <label for="description">Описание проекта:</label>
                        <textarea name="description" id="description" rows="3" class="form-control" required placeholder="Опишите проект ученика...">{{ old('description') }}</textarea>
                        @error('description') <p class="error">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit" class="btn">Создать проект</button>
                </form>
            </div>
        </div>
        <script>
        const students = @json($students);
        
        document.addEventListener('DOMContentLoaded', function() {
            const studentSearch = document.getElementById('student_search');
            const studentIdInput = document.getElementById('student_id');
            const studentSuggestions = document.getElementById('student_suggestions');
            const modulInfo = document.getElementById('modul_info');
            const modulIdInput = document.getElementById('modul_id');
            const modulNameInput = document.getElementById('modul_name');
            const mediaInput = document.getElementById('media');
            const mediaPreview = document.getElementById('media_preview');

            // Восстанавливаем старые значения при загрузке страницы
            if (studentIdInput.value) {
                const selectedStudent = students.find(student => student.student_id == studentIdInput.value);
                if (selectedStudent) {
                    studentSearch.value = selectedStudent.student_name;
                    modulInfo.textContent = selectedStudent.modul_name;
                    modulIdInput.value = selectedStudent.modul_id;
                    modulNameInput.value = selectedStudent.modul_name;
                }
            }

            // Обработка поиска ученика
            studentSearch.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const filteredStudents = students.filter(student => 
                    student.student_name.toLowerCase().includes(searchTerm)
                );

                studentSuggestions.innerHTML = '';
                if (searchTerm.length > 0) {
                    filteredStudents.forEach(student => {
                        const div = document.createElement('div');
                        div.className = 'suggestion-item';
                        div.textContent = student.student_name;
                        div.addEventListener('click', () => {
                            studentSearch.value = student.student_name;
                            studentIdInput.value = student.student_id;
                            modulInfo.textContent = student.modul_name;
                            modulIdInput.value = student.modul_id;
                            modulNameInput.value = student.modul_name;
                            studentSuggestions.innerHTML = '';
                        });
                        studentSuggestions.appendChild(div);
                    });
                }
            });

            // Предпросмотр медиафайла
            mediaInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    const preview = document.createElement(file.type.startsWith('image/') ? 'img' : 'video');
                    
                    reader.onload = function(e) {
                        mediaPreview.innerHTML = '';
                        preview.src = e.target.result;
                        if (file.type.startsWith('video/')) {
                            preview.controls = true;
                        }
                        mediaPreview.appendChild(preview);
                        mediaPreview.classList.add('active');
                    };

                    if (file.type.startsWith('image/')) {
                        reader.readAsDataURL(file);
                    } else if (file.type.startsWith('video/')) {
                        preview.src = URL.createObjectURL(file);
                        mediaPreview.appendChild(preview);
                        mediaPreview.classList.add('active');
                    }
                }
            });

            // Закрытие подсказок при клике вне поля поиска
            document.addEventListener('click', function(e) {
                if (!studentSearch.contains(e.target) && !studentSuggestions.contains(e.target)) {
                    studentSuggestions.innerHTML = '';
                }
            });

            // Drag and drop для загрузки файла
            const dropZone = document.querySelector('.file-upload-label');
            
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            ['dragenter', 'dragover'].forEach(eventName => {
                dropZone.addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, unhighlight, false);
            });

            function highlight(e) {
                dropZone.classList.add('highlight');
            }

            function unhighlight(e) {
                dropZone.classList.remove('highlight');
            }

            dropZone.addEventListener('drop', handleDrop, false);

            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                mediaInput.files = files;
                const event = new Event('change');
                mediaInput.dispatchEvent(event);
            }
        });
    </script>
    </section>

    
</x-layout>
