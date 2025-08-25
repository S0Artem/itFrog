<x-layout>
@vite(['resources/views/admin/adminAplication/aplication.css'])

<section class="admin__aplication__section">
    <h2>Заявки</h2>

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('success_id') && session('success_' . session('success_id')))
        <div class="alert alert-success">
            {{ session('success_' . session('success_id')) }}
        </div>
    @endif

    @if (session('success') && session('deleted_id'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Форма фильтрации --}}
    <form method="GET" action="{{ route('showeAdminApplication') }}" class="aplication__filter-form">
        <input type="text" name="name" placeholder="ФИО родителя" value="{{ request('name') }}">
        <input type="email" name="email" placeholder="Почта" value="{{ request('email') }}">
        <input type="text" name="number" placeholder="Телефон" value="{{ request('number') }}">
        <input type="number" name="age" placeholder="Возраст (лет)" value="{{ request('age') }}">

        <select name="branch_id">
            <option value="">Все филиалы</option>
            @foreach(\App\Models\Branch::all() as $branch)
                <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                    {{ $branch->sity }} {{ $branch->adres }}
                </option>
            @endforeach
        </select>

        <select name="status">
            <option value="">Все статусы</option>
            @foreach (['Новая', 'В работе', 'Отказ', 'Обработана', 'Пользователь создан', 'Готовая'] as $status)
                <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>
                    {{ $status }}
                </option>
            @endforeach
        </select>

        <div class="filter-options">
            <label class="checkbox-label">
                <input type="checkbox" name="show_ready" value="1" {{ request('show_ready') ? 'checked' : '' }}>
                Показать готовые заявки и отказы
            </label>
        </div>

        <button type="submit">Фильтровать</button>
        <a href="{{ route('showeAdminApplication') }}" class="aplication__reset-button">Сбросить</a>
    </form>


    {{-- Список заявок --}}
    <div class="aplication">
        @foreach ($applications as $application)
            <div id="application_{{ $application->id }}" class="aplication__card">
                <div class="aplication__info">
                    <h4>Родитель</h4>
                    <p><strong>ФИО:</strong> {{ $application->name ?? 'нет информации' }}</p>
                    <p><strong>Почта:</strong> {{ $application->email ?? 'нет информации' }}</p>
                    <p><strong>Телефон:</strong> {{ $application->number ?? 'нет информации' }}</p>
                    @if($application->user)
                        <p><strong>Пользователь в системе:</strong> {{ $application->user->name }} (ID: {{ $application->user->id }})</p>
                    @endif

                    <h4>Ребенок</h4>
                    <p><strong>ФИО:</strong> {{ $application->student_name ?? 'нет информации' }}</p>
                    <p><strong>Возраст:</strong> {{ $application->age_text }}</p>
                    <p><strong>Филиал:</strong> 
                        @if($application->branch)
                            {{ $application->branch->sity }}, {{ $application->branch->adres }}
                        @else
                            нет информации
                        @endif
                    </p>

                    <h4>Время</h4>
                    <p><strong>Создана:</strong> {{ $application->created_at->format('d.m.Y H:i') }}</p>
                    <p><strong>Обновлена:</strong> {{ $application->updated_at->format('d.m.Y H:i') }}</p>
                </div>

                @if ($errors->has('application_' . $application->id))
                    <div class="error">
                        {{ $errors->first('application_' . $application->id) }}
                    </div>
                @endif

                @if (session('success_' . $application->id))
                    <div class="alert alert-success">
                        {{ session('success_' . $application->id) }}
                    </div>
                @endif

                @if ($application->status !== 'Готовая')
                    <form action="{{ route('applicationChange', $application->id) }}" method="post" class="aplication__form">
                        @csrf
                        @method('PATCH')
                        <select name="status" id="status_{{ $application->id }}" class="aplication__select"
                                onchange="handleStatusChange(this, {{ $application->id }})">
                            <option value="Новая" {{ $application->status === 'Новая' ? 'selected' : '' }}>Новая</option>
                            <option value="В работе" {{ $application->status === 'В работе' ? 'selected' : '' }}>В работе</option>
                            <option value="Отказ" {{ $application->status === 'Отказ' ? 'selected' : '' }}>Отказ</option>
                            <option value="Обработана" {{ $application->status === 'Обработана' ? 'selected' : '' }}>Обработана</option>
                            <option value="Пользователь создан" {{ $application->status === 'Пользователь создан' ? 'selected' : '' }}>Пользователь создан</option>
                            <option value="Готовая" {{ $application->status === 'Готовая' ? 'selected' : '' }}>Готовая</option>
                        </select>

                        <div id="user_select_{{ $application->id }}" class="user-select-container" style="display: none;">
                            <select name="user_id" class="aplication__select" required>
                                <option value="">Выберите пользователя</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                @endforeach
                            </select>
                            @if ($errors->has('user_id'))
                                <div class="error">{{ $errors->first('user_id') }}</div>
                            @endif
                        </div>

                        @if($application->status === 'Пользователь создан' && $application->user)
                            <div class="aplication__user-info">Пользователь: <strong>{{ $application->user->name }}</strong> ({{ $application->user->email }})</div>
                        @endif

                        @if ($application->status === 'Обработана')
                            <a href="{{ route('showeRegisterUser', [
                                'email' => $application->email,
                                'name' => $application->name,
                                'number' => $application->number,
                                'idAplication' => $application->id
                            ]) }}" class="aplication__button">Зарегистрировать</a>
                        @endif

                        @if ($application->status === 'Пользователь создан')
                            <a href="{{ route('showeRegisterStudent', [
                                'student_name' => $application->student_name,
                                'student_birth_date' => $application->student_birth_date,
                                'branch_id' => $application->branch_id,
                                'user_id' => $application->user_id,
                                'aplication_id' => $application->id
                            ]) }}" class="aplication__button">Зарегистрировать ученика</a>
                        @endif

                    </form>
                    @if ($application->status === 'Отказ')
                        <form action="{{ route('deleteApplication', $application->id) }}" method="post" class="aplication__delete-form" onsubmit="return confirm('Вы уверены, что хотите удалить эту заявку?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="aplication__delete-button">Удалить заявку</button>
                        </form>
                    @endif
                    
                @else
                    <div class="aplication__ready">
                        <select name="status" class="aplication__select" disabled>
                            <option value="Готовая" selected>Готовая</option>
                        </select>
                        <p>Заявка завершена. Изменения невозможны.</p>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
    <script>
function handleStatusChange(select, applicationId) {
    const userSelectContainer = document.getElementById('user_select_' + applicationId);
    const form = select.closest('form');
    
    if (select.value === 'Пользователь создан') {
        userSelectContainer.style.display = 'block';
        // Не отправляем форму автоматически, ждем выбора пользователя
    } else {
        userSelectContainer.style.display = 'none';
        // Отправляем форму для других статусов
        form.submit();
    }
}

// Автоматический переход к заявке после обновления
document.addEventListener('DOMContentLoaded', function() {
    @if(session('scroll_to_id'))
        const targetId = {{ session('scroll_to_id') }};
        const targetElement = document.getElementById('application_' + targetId);
        if (targetElement) {
            targetElement.scrollIntoView({ 
                behavior: 'smooth', 
                block: 'center' 
            });
            
            // Добавляем подсветку
            targetElement.style.backgroundColor = '#e8f5e8';
            setTimeout(() => {
                targetElement.style.backgroundColor = '';
            }, 3000);
        }
    @endif
});

// Обработка выбора пользователя
document.addEventListener('change', function(e) {
    if (e.target.name === 'user_id') {
        const form = e.target.closest('form');
        if (form) {
            form.submit();
        }
    }
});
</script>
</section>


</x-layout>
