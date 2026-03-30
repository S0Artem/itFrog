@vite(['resources/views/home/component/form/form.css'])
@vite(['resources/views/home/component/form/form.js'])
<section class="home__form__section" id="home__form">
    <div class="home__form__contenteiner">
        <div class="form-container">
            <h2>ПОЛУЧИТЬ КОНСУЛЬТАЦИЮ</h2>
            <p>Оставьте контакты, и менеджеры учебного отдела помогут Вам подобрать курс</p>
            
            @if (session('form'))
                <div class="alert alert-success">
                    {{ session('form') }}
                </div>
            @endif

            @auth
                @if(Auth::user()->role === 'admin')
                    <div class="form-blocked">
                        <div class="blocked-message">
                            <h3>Форма недоступна</h3>
                            <p>Сначала выйдите из профиля администратора, чтобы оставить заявку.</p>
                            <a href="{{ route('auth.logout') }}" class="btn btn-auth.logout">Выйти из профиля</a>
                        </div>
                    </div>
                @elseif(Auth::user()->role === 'teacher')
                    <div class="form-blocked">
                        <div class="blocked-message">
                            <h3>Форма недоступна</h3>
                            <p>Сначала выйдите из профиля учителя, чтобы оставить заявку.</p>
                            <a href="{{ route('auth.logout') }}" class="btn btn-auth.logout">Выйти из профиля</a>
                        </div>
                    </div>
                @else
                    {{-- Форма для авторизованных пользователей (user) --}}
                    <form action="{{ route('application.store') }}" method="POST">
                        @csrf
                        
                        {{-- Скрытые поля с данными пользователя --}}
                        <input type="hidden" name="name" value="{{ Auth::user()->name }}">
                        <input type="hidden" name="email" value="{{ Auth::user()->email }}">
                        <input type="hidden" name="number" value="{{ Auth::user()->number }}">
                        
                        <div class="form-group">
                            <input type="text" name="student_name" placeholder="ФИО ребенка" value="{{ old('student_name') }}" required>
                        </div>
                        @error('student_name') <p class="error">{{ $message }}</p> @enderror

                        <div class="form-group">
                            <select name="branch_id" id="branch_id" class="form-select" required>
                                <option value="">Выберите филиал</option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch['id'] }}" {{ old('branch_id') == $branch['id'] ? 'selected' : '' }}>
                                        {{ $branch['sity'] }}, {{ $branch['adres'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>День рождение ребенка</label>
                            <input type="date" name="birthdate" value="{{ old('birthdate') }}" required>
                        </div>
                        @error('birthdate') <p class="error">{{ $message }}</p> @enderror
                        
                        <button type="submit" class="btn">ПОЛУЧИТЬ КОНСУЛЬТАЦИЮ</button>
                    </form>
                @endif
            @else
                {{-- Форма для неавторизованных пользователей --}}
                <form action="{{ route('application.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <input type="text" name="name" placeholder="Ваше ФИО" value="{{ old('name') }}" required>
                    </div>
                    @error('name') <p class="error">{{ $message }}</p> @enderror
                    <div class="form-group">
                        <input type="email" name="email" placeholder="Электронная почта" value="{{ old('email') }}" required>
                    </div>
                    @error('email') <p class="error">{{ $message }}</p> @enderror
                    <div class="form-group">
                        <label>Ваш номер телефона</label>
                        <input type="text" id="phone" name="number" placeholder="+7 (___) ___-__-__" value="{{ old('number') }}" required>
                    </div>
                    @error('number') <p class="error">{{ $message }}</p> @enderror
                    <div class="form-group">
                        <input type="text" name="student_name" placeholder="ФИО ребенка" value="{{ old('student_name') }}" required>
                    </div>
                    @error('student_name') <p class="error">{{ $message }}</p> @enderror

                    <div class="form-group">
                        <select name="branch_id" id="branch_id" class="form-select" required>
                            <option value="">Выберите филиал</option>
                            @foreach($branches as $branch)
                                <option value="{{ $branch['id'] }}" {{ old('branch_id') == $branch['id'] ? 'selected' : '' }}>
                                    {{ $branch['sity'] }}, {{ $branch['adres'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('branch_id') <p class="error">{{ $message }}</p> @enderror

                    <div class="form-group">
                        <label>День рождение ребенка</label>
                        <input type="date" name="student_birth_date" value="{{ old('student_birth_date') }}" required>
                    </div>
                    @error('birthdate') <p class="error">{{ $message }}</p> @enderror

                    <button type="submit" class="btn">ПОЛУЧИТЬ КОНСУЛЬТАЦИЮ</button>
                </form>
            @endauth
            
            <p class="form-footer">Нажимая на кнопку, я соглашаюсь на <a href="{{ asset('docs/privacy-policy.pdf') }}" download="Политика_конфиденциальности.pdf">обработку персональных данных</a></p>
        </div>
    </div>
</section>