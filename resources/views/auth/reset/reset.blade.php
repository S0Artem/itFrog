<x-layout>
    @vite(['resources/views/auth/login/login.css']) {{-- Подключаем тот же CSS, что и для логина --}}
    <section class="login__section">
        <div class="login__contenteiner">
            <div class="login-container">
                <h2>Восстановление пароля</h2>
                <p>Восстановление пароля по почте. Новый пароль придёт на почту.</p>
                <form action="{{ route('resetUser') }}" method="post">
                    @csrf
                    <div class="login-group">
                        <input name="email" type="email" placeholder="Почта пользователя" value="{{ old('email') }}">
                    </div>
                    @error('email') <p class="error">{{ $message }}</p> @enderror
                    <button type="submit" class="btn">Отправить</button>
                </form>
            </div>
        </div>
    </section>
</x-layout>
