<x-layout>
    @vite(['resources/views/admin/adminUsers/adminUsers.css'])

    <!-- Include Inputmask via CDN -->
    <script src="https://cdn.jsdelivr.net/npm/inputmask@5/dist/inputmask.min.js"></script>

    <section class="admin__users__section">
        <h2>Пользователи</h2>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <!-- Filter Form -->
        <form method="GET" action="{{ route('admin.users.index') }}" class="users__filter-form">
            <input type="text" name="name" placeholder="ФИО родителя" value="{{ request('name') }}">
            <input type="email" name="email" placeholder="Почта" value="{{ request('email') }}">
            <input type="text" name="number" placeholder="Телефон" value="{{ request('number') }}">
            <select name="branch_id">
                <option value="">Все филиалы</option>
                @foreach(\App\Models\Branch::all() as $branch)
                    <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                        {{ $branch->sity }} {{ $branch->adres }}
                    </option>
                @endforeach
            </select>
            <select name="role">
                <option value="">Все роли</option>
                @foreach (['user', 'teacher', 'admin'] as $role)
                    <option value="{{ $role }}" {{ request('role') === $role ? 'selected' : '' }}>
                        {{ $role === 'user' ? 'Родитель' : ($role === 'teacher' ? 'Учитель' : 'Админ') }}
                    </option>
                @endforeach
            </select>
            <button type="submit">Фильтровать</button>
            <a href="{{ route('admin.users.index') }}" class="users__reset-button">Сбросить</a>
        </form>

        <!-- Users List -->
        <div class="users__list">
            @foreach ($users as $user)
                <div id="user_{{ $user->id }}" class="user__card">
                    <div class="user__info">
                        <h4>{{ $user->role === 'user' ? 'Родитель' : ($user->role === 'teacher' ? 'Учитель' : 'Админ') }}</h4>
                        <p><strong>ФИО:</strong> {{ $user->name }}</p>
                        <p><strong>Почта:</strong> {{ $user->email }}</p>
                        <p><strong>Телефон:</strong> 
                            @if ($user->number)
                                <a href="tel:{{ $user->number }}" class="phone-link">{{ $user->number }}</a>
                            @else
                                нет информации
                            @endif
                        </p>

                        @if ($user->role === 'user' && $user->student->count() > 0)
                            <button class="toggle-students" data-target="students-{{ $user->id }}">
                                Дети ({{ $user->student->count() }})
                                <svg class="toggle-icon" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                            <div id="students-{{ $user->id }}" class="students__container hidden">
                                @foreach ($user->student as $index => $student)
                                    <div class="student__block">
                                        <h4>Ребёнок №{{ $index + 1 }}</h4>
                                        <p><strong>ФИО:</strong> {{ $student->name }}</p>
                                        <p><strong>Возраст:</strong> {{ $student->age_text }}</p>
                                        <p><strong>Филиал:</strong> 
                                            {{ $student->branch ? "{$student->branch->sity}, {$student->branch->adres}" : 'нет информации' }}
                                        </p>
                                        <p><strong>Занимается в группе:</strong>
                                            @if ($student->groups->count() > 0)
                                                @foreach ($student->groups as $group)
                                                    {{ $group->modul->name }} ({{ $group->time->lesson_start }} - {{ $group->time->lesson_end }})
                                                @endforeach
                                            @else
                                                Не записан в группы.
                                            @endif
                                        </p>
                                        <p><strong>Дата последней оплаты:</strong>
                                            @if ($student->groups->count() > 0 && $student->groups->first()->pivot->last_payment_date)
                                                {{ $student->groups->first()->formatted_payment_date }} - 
                                                {{ $student->groups->first()->formatted_expiry_date }}
                                                ({{ $student->groups->first()->is_payment_overdue ? 'просрочено' : $student->groups->first()->payment_display }})
                                            @else
                                                нет информации
                                            @endif
                                        </p>

                                        <!-- Success Message -->
                                        @if (session('success_student_' . $student->id))
                                            <div class="alert alert-success">
                                                {{ session('success_student_' . $student->id) }}
                                            </div>
                                        @endif

                                        <!-- Error Message -->
                                        @if ($errors->has('student_' . $student->id))
                                            <div class="error">
                                                {{ $errors->first('student_' . $student->id) }}
                                            </div>
                                        @endif

                                        <!-- Student Edit Form -->
                                        <form action="{{ route('admin.students.update', $student->id) }}" method="POST" class="student__form">
                                            @csrf
                                            @method('PATCH')
                                            <input type="text" name="name" value="{{ $student->name }}" placeholder="ФИО">
                                            <input type="date" name="birthdate" value="{{ $student->birthdate ? \Carbon\Carbon::parse($student->birthdate)->format('Y-m-d') : '' }}" placeholder="Дата рождения">

                                            <button type="submit" class="student__button">Сохранить</button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Success Message -->
                    @if (session('success_user_' . $user->id))
                        <div class="alert alert-success">
                            {{ session('success_user_' . $user->id) }}
                        </div>
                    @endif

                    <!-- Error Message -->
                    @if ($errors->has('user_' . $user->id))
                        <div class="error">
                            {{ $errors->first('user_' . $user->id) }}
                        </div>
                    @endif

                    <!-- Edit Form -->
                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="user__form">
                        @csrf
                        @method('PATCH')
                        <input type="text" name="name" value="{{ $user->name }}" placeholder="ФИО">
                        <input type="email" name="email" value="{{ $user->email }}" placeholder="Почта">
                        <input type="text" name="number" value="{{ $user->number }}" placeholder="Телефон" class="phone-input">
                        <select name="role">
                            @foreach (['user', 'teacher', 'admin'] as $role)
                                <option value="{{ $role }}" {{ $user->role === $role ? 'selected' : '' }}>
                                    {{ $role === 'user' ? 'Родитель' : ($role === 'teacher' ? 'Учитель' : 'Админ') }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="user__button">Сохранить</button>
                    </form>

                    <!-- Reset Password Form -->
                    <form action="{{ route('admin.users.reset-password', $user->id) }}" method="POST" class="user__form">
                        @csrf
                        <button type="submit" class="user__button user__button--reset">Сбросить пароль</button>
                    </form>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="pagination">
            @if ($users->lastPage() > 1)
                <div class="pagination__wrapper">
                    <!-- Previous Page Link -->
                    @if ($users->onFirstPage())
                        <span class="pagination__link pagination__link--disabled">
                            <svg class="pagination__icon" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </span>
                    @else
                        <a href="{{ $users->previousPageUrl() }}" class="pagination__link" rel="prev">
                            <svg class="pagination__icon" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </a>
                    @endif

                    <!-- Page Numbers -->
                    @php
                        $currentPage = $users->currentPage();
                        $lastPage = $users->lastPage();
                        $range = 2; // Number of pages to show before/after current page
                        $start = max(1, $currentPage - $range);
                        $end = min($lastPage, $currentPage + $range);
                    @endphp

                    @if ($start > 1)
                        <a href="{{ $users->url(1) }}" class="pagination__link">1</a>
                        @if ($start > 2)
                            <span class="pagination__ellipsis">...</span>
                        @endif
                    @endif

                    @for ($i = $start; $i <= $end; $i++)
                        @if ($i == $currentPage)
                            <span class="pagination__link pagination__link--active">{{ $i }}</span>
                        @else
                            <a href="{{ $users->url($i) }}" class="pagination__link">{{ $i }}</a>
                        @endif
                    @endfor

                    @if ($end < $lastPage)
                        @if ($end < $lastPage - 1)
                            <span class="pagination__ellipsis">...</span>
                        @endif
                        <a href="{{ $users->url($lastPage) }}" class="pagination__link">{{ $lastPage }}</a>
                    @endif

                    <!-- Next Page Link -->
                    @if ($users->hasMorePages())
                        <a href="{{ $users->nextPageUrl() }}" class="pagination__link" rel="next">
                            <svg class="pagination__icon" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </a>
                    @else
                        <span class="pagination__link pagination__link--disabled">
                            <svg class="pagination__icon" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </span>
                    @endif
                </div>
                <div class="pagination__info">
                    Показаны {{ $users->firstItem() }}–{{ $users->lastItem() }} из {{ $users->total() }} результатов
                </div>
            @endif
        </div>

        <!-- JavaScript for Toggling Students and Input Mask -->
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Toggle Students
                document.querySelectorAll('.toggle-students').forEach(button => {
                    button.addEventListener('click', () => {
                        const targetId = button.getAttribute('data-target');
                        const container = document.getElementById(targetId);
                        const icon = button.querySelector('.toggle-icon');
                        container.classList.toggle('hidden');
                        icon.classList.toggle('rotated');
                    });
                });

                // Initialize Inputmask for phone inputs
                Inputmask({
                    mask: "+7(999)-999-99-99",
                    placeholder: "_",
                    clearIncomplete: true,
                    showMaskOnHover: false,
                    onBeforePaste: function (pastedValue, opts) {
                        const cleanedValue = pastedValue.replace(/\D/g, '');
                        return cleanedValue;
                    }
                }).mask(document.querySelectorAll('.phone-input'));
            });
        </script>
    </section>
</x-layout>