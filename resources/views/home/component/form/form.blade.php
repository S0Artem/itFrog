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
            <form action="{{ route('aplication.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <input type="text" name="name" placeholder="Ваше имя" required>
                </div>
                <div class="form-group">
                    <input type="email" name="email" placeholder="Электронная почта" required>
                </div>
                <div class="form-group">
                    <input type="text" id="phone" name="number" placeholder="+7 (___) ___-__-__" required>
                </div>
                <button type="submit" class="btn">ПОЛУЧИТЬ КОНСУЛЬТАЦИЮ</button>
            </form>
            <p class="form-footer">Нажимая на кнопку, я соглашаюсь на <a href="{{ asset('docs/privacy-policy.pdf') }}" download="Политика_конфиденциальности.pdf">обработку персональных данных</a></p>
        </div>
    </div>
</section>