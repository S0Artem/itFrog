<x-layout>
    @vite(['resources/views/admin/adminRegister/employee/register.css'])
    @vite(['resources/views/home/component/form/form.js'])
    <section class="register__section">
        <div class="register__contenteiner">
            <div class="register-container">
                <h2>Регистрация сотрудника</h2>
                @if (session('register'))
                    <div class="alert alert-register">
                        {{ session('register') }}
                    </div>
                @endif
                <p>Регистрация нового пользователя в системе. Логин и пароль придут на почту.</p>

                <form action="{{ route('submitRegisterEmployee') }}" method="post">
                    @csrf
                    
                    <div class="name-group">
                        <label for="name">ФИО сотрудника</label>
                        <input name="name" id="name" type="text" placeholder="ФИО сотрудника" value="{{ old('name') }}">
                        @error('name')<p class="error">{{ $message }}</p>@enderror
                    </div>
                    
                    <div class="email-group">
                        <label for="email">Email</label>
                        <input name="email" id="email" type="email" placeholder="Email" value="{{ old('email') }}">
                        @error('email')<p class="error">{{ $message }}</p>@enderror
                    </div>
                    
                    <div class="number-group">
                        <label for="number">Номер телефона</label>
                        <input type="tel" 
                               id="number" 
                               name="number" 
                               placeholder="+7 (___) ___-__-__" 
                               value="{{ old('number') }}"
                               required>
                        @error('number')<p class="error">{{ $message }}</p>@enderror
                    </div>

                    <div class="name-group">
                        <label for="birthdate">Дата рождения сотрудника</label>
                        <input type="date" name="birthdate" id="birthdate" value="{{ old('birthdate') }}" class="form-control">
                        @error('birthdate')<p class="error">{{ $message }}</p>@enderror
                    </div>

                    <div class="email-group">
                        <label for="branch_id">Филиал</label>
                        <select name="branch_id" id="branch_id" class="form-select">
                            <option value="">Выберите филиал</option>
                            @foreach($branchs as $branch)
                                <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                                    {{ $branch->sity }}, {{ $branch->adres }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn">Зарегистрировать</button>
                </form>
            </div>
        </div>
    </section>
</x-layout>