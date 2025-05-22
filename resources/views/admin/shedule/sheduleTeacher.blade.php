<x-layout>
    @vite(['resources/views/admin/shedule/shedule.css'])

    <section class="admin-schedule">
        <div class="container">
            <h2>Расписание филиалов</h2>
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
                                    <a href="{{ route('group.show', ['group' => $group->id ]) }}" class="lesson-module">{{ $group->modul->name }}</a>
                                </div>
                            @endforeach
                        @else
                            <p class="lesson-empty">Пусто</p>
                        @endif
                        </div>
                    @endforeach
                @endforeach
            </div>
        </div>
    </section>
</x-layout>