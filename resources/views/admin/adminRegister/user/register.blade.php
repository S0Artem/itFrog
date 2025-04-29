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
                <p>Регистрация нового пользователя в системе. Логин и пароль прийдет на почту</p>
                <form action="{{ route('submitRegisterUser') }}" method="post">
                    @csrf
                    <input type="hidden" name="idAplication" value="{{ $idAplication }}">

                        
    
                        <div class="name-group">
                            <input name="name" type="name" placeholder="Имя пользователя " value="{{ old('name', $name) }}" >
                        </div>
                        @error('name') <p class="error">{{ $message }}</p> @enderror
                        <div class="email-group">
                            <input name="email" type="email" placeholder="Почта пользователя" value="{{ old('email', $email) }}">
                        </div>
                        @error('email') <p class="error">{{ $message }}</p> @enderror
                        <div class="number-group">
                            <input type="tel" 
                                   id="phone" 
                                   name="number" 
                                   placeholder="+7 (___) ___-__-__" 
                                   value="{{ old('number', $number ?? '') }}"
                                   required>
                        </div>
                        @error('number') <p class="error">{{ $message }}</p> @enderror
    
                        <button type="submit" class="btn">Зарегестрировать</button>
                    </form>
            </div>
        </div>
    </section>
</x-layout>