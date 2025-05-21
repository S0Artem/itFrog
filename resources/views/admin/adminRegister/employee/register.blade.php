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
                <p>Регистрация нового пользователя в системе. Логин и пароль прийдет на почту</p>

                <form action="{{ route('submitRegisterEmployee') }}" method="post">
                    @csrf
                    

                    <div class="name-group">
                        <input name="name" type="name" placeholder="ФИО пользователя " value="{{ old('name') }}" >
                    </div>
                    @error('name') <p class="error">{{ $message }}</p> @enderror
                    <div class="email-group">
                        <input name="email" type="email" placeholder="Почта пользователя" value="{{ old('email') }}">
                    </div>
                    @error('email') <p class="error">{{ $message }}</p> @enderror
                    <div class="number-group">
                        <label>Номер телефона</label>
                        <input type="tel" 
                               id="phone" 
                               name="number" 
                               placeholder="+7 (___) ___-__-__" 
                               value="{{ old('number' ?? '') }}"
                               required>
                    </div>
                    @error('number') <p class="error">{{ $message }}</p> @enderror

                    <div class="email-group">
                        <select name="branch_id" id="branch" class="form-select">
                            @foreach($branchs as $branch)
                                <option value="{{ $branch->id }}">
                                    {{ $branch->sity }}, {{ $branch->adres }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    

                    <button type="submit" class="btn">Зарегестрировать</button>
                </form>
            </div>
        </div>
    </section>
</x-layout>