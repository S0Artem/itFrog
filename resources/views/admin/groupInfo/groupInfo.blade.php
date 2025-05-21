<x-layout>
    @vite(['resources/views/admin/groupInfo/groupInfo.css'])
    
    <section class="admin-group">
        <div class="container">
            <!-- Кнопка возврата -->
            @if (Auth::check() && Auth::user()->role === 'admin')
            <a href="{{ route('showeShedule', ['branch_id' => $selectedBranch]) }}"
                class="btn btn-back">
                 ← Назад к расписанию
            </a>
            @else
            <a href="{{ route('showeSheduleTeacher') }}" 
                class="btn btn-back">
                 ← Назад к расписанию
            </a>
            @endif
            
            <!-- Информация о группе -->
            <div class="group-info">
                <h2>{{ $group->modul->name }}</h2>
                <p><strong>Преподаватель:</strong> 
                    {{ $group->teacher->employee->user->name ?? 'Не назначен' }}</p>
                <p><strong>Телефон преподавателя:</strong> 
                    {{ $group->teacher->employee->user->number ?? 'Не указан' }}</p>
                <p><strong>Филиал:</strong> 
                    {{ $group->branch->sity }}, {{ $group->branch->adres }}</p>
            </div>
            
            <!-- Список учеников -->
            <div class="students-list">
                <h3>Ученики группы:</h3>
                <ul>
                    @foreach($students as $student)
                        <li>
                            {{ $student['name'] }}
                            <span  class="student-info">
                                Телефон: {{ $student['phone'] }},
                                Возраст: {{ $student['birthdate'] ? \Carbon\Carbon::parse($student['birthdate'])->age : 'Не указан' }},
                                Абонемент: {{ $student['paymentDisplay'] }}

                                @if($student['isOverdue'])
                                    <span style="color: red; font-weight: bold; margin-left: 8px;">Просрочено</span>
                                @endif
                            </span>
                        </li>
                    @endforeach
                </ul>


            </div>
        </div>
    </section>
</x-layout>