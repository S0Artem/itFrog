<x-layout>
    @vite(['resources/views/login/login.css'])
    <section class="login__section">
        <div class="login__contenteiner">
            <div class="login-container">
                <h2>ВХОД</h2>
                <p>Вход в личный кабинет, данные личного кабинета вам выдадут при записи ребенка на занятия</p>
                <form action="{{ route('submitLogin') }}" method="post">
                    {{-- //TODO:Смена пароля при потере --}}
                    @csrf
                    <div class="login-group">
                        <input name="login" type="login" placeholder="Ваш логин" value="{{ old('login') }}">
                    </div>
                    @error('login') <p class="error">{{ $message }}</p> @enderror
                    <div class="login-group">
                        <input name="password" type="password" placeholder="Ваш пароль">
                    </div>
                    @error('password') <p class="error">{{ $message }}</p> @enderror
                    <button type="submit" class="btn">Войти</button>
                </form>
                <p class="login-footer">Если забыли логин или пароль <a href="#">нажмите</a></p>
            </div>
        </div>
    </section>
</x-layout>