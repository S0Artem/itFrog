<x-layout>
    @vite(['resources/views/admin/adminRegister/student/register.css'])
    @vite(['resources/views/admin/adminRegister/student/registerStudentFilter.js'])
    <section class="register__section">
        <div class="register__contenteiner">
            <div class="register-container">
                <h2>Регистрация пользователя</h2>
                @if (session('register'))
                    <div class="alert alert-register">
                        {{ session('register') }}
                    </div>
                @endif
                <p>Регистрация нового пользователя в системе. Логин и пароль придут на почту.</p>
                <form action="{{ route('submitRegisterStudent') }}" method="post">
                    @csrf
                
                    <div class="name-group">
                        <label for="name">ФИО ученика</label>
                        <input name="name" id="name" type="text" placeholder="ФИО ученика" value="{{ old('name', $student_name) }}">
                        @error('name')<p class="error">{{ $message }}</p>@enderror
                    </div>
                
                    <!-- Поле даты рождения -->
                    <div class="name-group">
                        <label for="birthdate">Дата рождения ребёнка</label>
                        <input type="date" name="birthdate" id="birthdate" value="{{ old('birthdate', $student_birth_date) }}" class="form-control">
                        @error('birthdate')<p class="error">{{ $message }}</p>@enderror
                    </div>
                
                    <!-- Выбор филиала -->
                    <div class="name-group">
                        <label for="branch_id">Филиал</label>
                        <select name="branch_id" id="branch_id" class="form-select">
                            <option value="">Выберите филиал</option>
                            @foreach($branchs as $branch)
                                <option value="{{ $branch->id }}" {{ old('branch_id', $branch_id ?? '') == $branch->id ? 'selected' : '' }}>
                                    {{ $branch->sity }}, {{ $branch->adres }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                
                    <!-- Выбор группы -->
                    <div class="name-group">
                        <label for="group_id">Группа</label>
                        <select name="group_id" id="group_id" class="form-select" disabled >
                            <option value="" id="group_placeholder">Сначала выберите филиал и укажите дату рождения</option>
                            @foreach($groups as $group)
                                <option 
                                    value="{{ $group->id }}" 
                                    data-branch="{{ $group->branch_id }}"
                                    data-min-age="{{ $group->modul->min_age }}"
                                    data-max-age="{{ $group->modul->max_age }}"
                                    {{ old('group_id') == $group->id ? 'selected' : '' }}
                                    hidden>
                                    {{ $group->modul->name }} 
                                    {{ $group->lessonTime->lesson_start }} - {{ $group->lessonTime->lesson_end }}
                                    @php
                                        $dayNames = [1 => 'Пн', 2 => 'Вт', 3 => 'Ср', 4 => 'Чт', 5 => 'Пт', 6 => 'Сб', 7 => 'Вс'];
                                    @endphp
                                    {{ $dayNames[$group->day] ?? $group->day }}                            
                                </option>
                            @endforeach
                        </select>
                    </div>
                
                    <div class="name-group">
                        <label for="user_id">Родитель</label>
                        <select name="user_id" id="user_id" class="form-select" {{ $user_id ? 'disabled' : '' }}>
                            <option value="">Выберите родителя</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id', $user_id ?? '') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                        @if ($user_id)
                            <input type="hidden" name="user_id" value="{{ $user_id }}">
                        @endif
                    </div>

                    @if (request('aplication_id'))
                        <input type="hidden" name="aplication_id" value="{{ request('aplication_id') }}">
                    @endif
                
                    <button type="submit" class="btn">Зарегистрировать</button>
                </form>
            </div>
        </div>
    </section>
</x-layout>
