<x-layout>
    @vite(['resources/views/admin/shedule/shedule.css'])
    @vite(['resources/views/admin/shedule/shedule.js'])

    <section class="admin-schedule">
        <div class="container">
            <!-- Выбор филиала -->
            <div class="branch-selector">
                <form method="GET" class="branch-form">
                    <select name="branch_id" class="form-select" onchange="this.form.submit()">
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" {{ $selectedBranch == $branch->id ? 'selected' : '' }}>
                                {{ $branch->sity }} - {{ $branch->adres }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
            
            <!-- Сетка расписания -->
            <div class="schedule-grid">
                <!-- Заголовки дней недели -->
                <div class="grid-header time-column">Время</div>
                @foreach(['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс'] as $dayIndex => $dayName)
                    <div class="grid-header day-column">{{ $dayName }}</div>
                @endforeach
                
                <!-- Строки с занятиями -->
                @foreach($times as $timeIndex => $time)
                    <div class="time-slot" 
                        data-time-id="{{ $time->id }}" 
                        data-time-index="{{ $timeIndex }}">
                        {{ substr($time->lesson_start, 0, 5) }} - {{ substr($time->lesson_end, 0, 5) }}
                    </div>
                    
                    @foreach(range(1, 7) as $day)
                        <div class="lesson-slot no-select" 
                            data-day="{{ $day }}" 
                            data-time-index="{{ $timeIndex }}">
                            @if(isset($groups[$day][$time->id]))
                                @foreach($groups[$day][$time->id] as $group)
                                    <div class="lesson-card">
                                        <div class="lesson-module">{{ $group->modul->name }}</div>
                                    </div>
                                @endforeach
                            @else
                                <button class="lesson-add">+ Добавить</button>
                            @endif
                        </div>
                    @endforeach
                @endforeach
            </div>
        </div>
        
        <div id="scheduleModal" class="modal">
            <div class="modal-content">
                <span class="modal-close">&times;</span>
                <h3 class="modal-title">Добавить группу</h3>
                
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <form id="scheduleForm" method="POST" action="{{ route('submitShedule') }}">
                    @csrf
                    <input type="hidden" name="branch_id" id="modal_branch_id" value="{{ $selectedBranch }}">
                    <input type="hidden" name="time_id" id="modal_time_id">
                    <input type="hidden" name="day" id="modal_day">
                    
                    <div class="form-group">
                        <label for="modul_id">Модуль *</label>
                        <select name="modul_id" id="modul_id" class="form-control" required>
                            <option value="">-- Выберите модуль --</option>
                            @foreach($moduls as $modul)
                                <option value="{{ $modul->id }}" {{ old('modul_id') == $modul->id ? 'selected' : '' }}>
                                    {{ $modul->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                        <button type="button" class="btn btn-secondary modal-close">Отмена</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</x-layout>