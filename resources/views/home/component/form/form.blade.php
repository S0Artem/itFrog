@vite(['resources/views/home/component/form/form.css'])
<section class="home__form__section">
    <div class="home__form__contenteiner">
        <div class="form-container">
            <h2>ПОЛУЧИТЬ КОНСУЛЬТАЦИЮ</h2>
            <p>Оставьте контакты, и менеджеры учебного отдела помогут Вам подобрать курс</p>
            <form>
                <div class="form-group">
                    <input type="text" placeholder="Ваше имя" required>
                </div>
                <div class="form-group">
                    <input type="email" placeholder="Электронная почта" required>
                </div>
                <div class="form-group phone-group">
                    <select>
                        <option>RU</option>
                    </select>
                    <input type="tel" placeholder="+7" required>
                </div>
                <button type="submit" class="btn">ПОЛУЧИТЬ КОНСУЛЬТАЦИЮ</button>
            </form>
            <p class="form-footer">Нажимая на кнопку, я соглашаюсь на <a href="#">обработку персональных данных</a></p>
        </div>
    </div>
</section>
