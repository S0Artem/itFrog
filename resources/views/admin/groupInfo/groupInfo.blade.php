<x-layout>
    @vite(['resources/views/admin/groupInfo/groupInfo.css'])
    
    <section class="admin-group">
        <div class="container">
            <!-- Кнопка возврата -->
            <a href="{{ route('showeShedule', ['branch_id' => $selectedBranch]) }}" 
               class="btn btn-back">
                ← Назад к расписанию
            </a>
            
            <!-- Информация о группе -->
            <div class="group-info">
                <h2>{{ $group->modul->name }}</h2>
                <p><strong>Преподаватель:</strong> 
                    {{ $group->teacher->employee->user->name ?? 'Не назначен' }}</p>
                <p><strong>Телефон преподавателя:</strong> 
                    {{ $group->teacher->employee->user->number ?? 'Не указан' }}</p>
            </div>
            
            <!-- Список учеников -->
            <div class="students-list">
                <h3>Ученики группы:</h3>
                <ul>
                    @foreach($group->students as $student)
                        <li>
                            {{ $student->user->name }}
                            <span class="student-info">
                                Телефон: {{ $student->user->number ?? 'Не указан' }},
                                Возраст: {{ $student->birthdate ? Carbon\Carbon::parse($student->birthdate)->age : 'Не указан' }}
                            </span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>
</x-layout>