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

            <!-- Форма добавления ученика (только для админа) -->
            @if (Auth::check() && Auth::user()->role === 'admin' && count($availableStudents) > 0)
            <div class="add-student-form">
                <h3>Добавить ученика в группу (доступно: {{ count($availableStudents) }}):</h3>
                @if(count($availableStudents) >= 50)
                <div style="background: #fff3cd; border: 1px solid #ffeaa7; padding: 10px; margin: 10px 0; border-radius: 4px;">
                    <strong>Внимание:</strong> Показаны первые 50 учеников из {{ count($availableStudents) }} доступных. 
                    Используйте поиск или фильтрацию для нахождения нужного ученика.
                </div>
                @endif
                <form action="{{ route('group.addStudent', ['group' => $group->id]) }}" method="post">
                    @csrf
                    <select name="student_id" required>
                        <option value="">Выберите ученика</option>
                        @foreach($availableStudents as $student)
                            <option value="{{ $student['id'] }}">
                                {{ $student['name'] }} {{ $student['phone'] }} - {{ $student['birthdate'] ? \Carbon\Carbon::parse($student['birthdate'])->age . ' лет' : 'Возраст не указан' }} - {{ $student['paymentInfo'] }}
                            </option>
                        @endforeach
                    </select>
                    <input type="hidden" name="selectedBranch" value="{{ $selectedBranch }}">
                    <button type="submit" class="btn btn-primary">Добавить ученика</button>
                </form>
            </div>
            @endif
            
            <!-- Список учеников -->
            <div class="students-list">
                <h3>Ученики группы:</h3>
                @if(count($students) === 0)
                    <p>В группе нет учеников, вы можете её расформировать.</p>
                    @if (Auth::check() && Auth::user()->role === 'admin')
                    <form action="{{ route('group.show.deleteGroop', ['group' => $group->id]) }}" method="post">
                        @csrf
                        <input type="hidden" name="group" value="{{ $group->id }}">
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Вы уверены, что хотите расформировать группу?')">Расформировать группу</button>
                    </form>
                    @endif
                @else
                <table style="width: 100%; border-collapse: collapse; margin: 20px 0; text-align: center;">
                    <thead>
                        <tr style="background-color: #f8f9fa;">
                            <th style="padding: 15px; border: 1px solid #dee2e6; text-align: center;">Имя</th>
                            <th style="padding: 15px; border: 1px solid #dee2e6; text-align: center;">Телефон</th>
                            <th style="padding: 15px; border: 1px solid #dee2e6; text-align: center;">Возраст</th>
                            <th style="padding: 15px; border: 1px solid #dee2e6; text-align: center;">Абонемент</th>
                            @if (Auth::check() && Auth::user()->role === 'admin')
                            <th style="padding: 15px; border: 1px solid #dee2e6; text-align: center;">Действия</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                            <tr style="border-bottom: 1px solid #dee2e6;">
                                <td style="padding: 15px; border: 1px solid #dee2e6; text-align: center;">{{ $student['name'] }}</td>
                                <td style="padding: 15px; border: 1px solid #dee2e6; text-align: center;">{{ $student['phone'] }}</td>
                                <td style="padding: 15px; border: 1px solid #dee2e6; text-align: center;">{{ $student['birthdate'] ? \Carbon\Carbon::parse($student['birthdate'])->age . ' лет' : 'Не указан' }}</td>
                                <td style="padding: 15px; border: 1px solid #dee2e6; text-align: center;">
                                    @if($student['isOverdue'])
                                        <span style="color: red;">{{ $student['paymentDisplay'] }}</span>
                                    @elseif($student['daysLeft'] !== null && $student['daysLeft'] <= 7)
                                        <span style="color: orange;">{{ $student['paymentDisplay'] }}</span>
                                    @elseif($student['daysLeft'] !== null && $student['daysLeft'] > 7)
                                        <span style="color: green;">{{ $student['paymentDisplay'] }}</span>
                                    @else
                                        {{ $student['paymentDisplay'] }}
                                    @endif
                                </td>
                                <td style="padding: 15px; border: 1px solid #dee2e6; text-align: center;">
                                    @if (Auth::check() && Auth::user()->role === 'admin')
                                    <form action="{{ route('group.show.delete', ['group' => $group->id]) }}" method="post" style="display: inline;">
                                        @csrf
                                        <input name="studentId" type="hidden" value="{{ $student['id'] }}">
                                        <input type="hidden" name="group" value="{{ $group->id }}">
                                        <input type="hidden" name="selectedBranch" value="{{ $selectedBranch }}">
                                        <button type="submit" class="btn btn-small" onclick="return confirm('Удалить ученика из группы?')">Удалить</button>
                                    </form>
                                    @else
                                    <span style="color: #6c757d;">Просмотр</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </div>
        <script>
        // Цветовое выделение просроченных абонементов в select
        document.addEventListener('DOMContentLoaded', function() {
            const select = document.querySelector('select[name="student_id"]');
            if (select) {
                const options = select.querySelectorAll('option');
                options.forEach(function(option) {
                    if (option.textContent.includes('Просрочено')) {
                        option.style.color = 'red';
                    } else if (option.textContent.includes('Осталось') && option.textContent.includes('дн.')) {
                        const daysText = option.textContent.match(/Осталось (\d+) дн./);
                        if (daysText) {
                            const days = parseInt(daysText[1]);
                            if (days <= 7) {
                                option.style.color = 'orange';
                            }
                            else if(days > 7) {
                                option.style.color = 'green';
                            }
                        }
                    }
                });
            }
        });
    </script>
    </section>

    
</x-layout>