<x-layout>
    @vite(['resources/views/admin/adminRegister/user/register.css'])
    @vite(['resources/views/home/component/form/form.js'])
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
                <form action="{{ route('submitRegisterUser') }}" method="post">
                    @csrf
                
                    <div class="name-group">
                        <label for="name">ФИО родителя</label>
                        <input name="name" id="name" type="text" placeholder="ФИО родителя" value="{{ old('name', $name) }}">
                        @error('name')<p class="error">{{ $message }}</p>@enderror
                    </div>
                
                    <div class="email-group">
                        <label for="email">Email</label>
                        <input name="email" id="email" type="email" placeholder="Email" value="{{ old('email', $email) }}">
                        @error('email')<p class="error">{{ $message }}</p>@enderror
                    </div>
                
                    <div class="number-group">
                        <label for="number">Номер телефона</label>
                        <input name="number" id="number" type="text" placeholder="Номер телефона" value="{{ old('number', $number) }}">
                        @error('number')<p class="error">{{ $message }}</p>@enderror
                    </div>


                    @if ($idAplication)
                        <input type="hidden" name="idAplication" value="{{ $idAplication }}">
                    @endif
                
                    <button type="submit" class="btn">Зарегистрировать</button>
                </form>
            </div>
        </div>
    </section>
</x-layout>