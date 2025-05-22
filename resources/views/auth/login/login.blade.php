<x-layout>
    @vite(['resources/views/auth/login/login.css'])
    <section class="login__section">
        <div class="login__contenteiner">
            <div class="login-container">
                <h2>ВХОД</h2>
                @if (session('reset'))
                    <div class="alert alert-register">
                        {{ session('reset') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="error error-register">
                        {{ session('error') }}
                    </div>
                @endif
                <p>Вход в личный кабинет, данные личного кабинета вам выдадут при записи ребенка на занятия</p>
                <form action="{{ route('submitLogin') }}" method="post">
                    @csrf
                    <div class="login-group">
                        <input name="login" type="login" placeholder="Ваша почта" value="{{ old('login') }}">
                    </div>
                    @error('login') <p class="error">{{ $message }}</p> @enderror
                    <div class="login-group">
                        <input name="password" type="password" placeholder="Ваш пароль">
                    </div>
                    @error('password') <p class="error">{{ $message }}</p> @enderror
                    <button type="submit" class="btn">Войти</button>
                </form>
                <p class="login-footer">Если забыли пароль <a href="{{ route('resetShowe') }}">Восстановить пароль</a></p>
            </div>
        </div>
    </section>
</x-layout>