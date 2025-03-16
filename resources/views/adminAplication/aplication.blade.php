<!-- Подключаем Swiper.js -->
<x-layout>
@vite(['resources/views/profilAdmin/component/aplication/aplication.css'])
<section class="admin__aplication__section">
    <h2>Заявки</h2>
    <div class="aplication">
        @foreach ($aplications as $aplication)
            <form action="{{ route('aplicationChange', $aplication->id) }}" method="post">
                @csrf
                @method('PUT')
                <p>Имя: {{ $aplication->name ?? 'нету инфы' }}, почта: {{ $aplication->email ?? 'нету инфы' }}</p>
                <select name="status" id="status">
                    <option value="Новая" {{ $aplication->status === 'Новая' ? 'selected' : '' }}>
                        Новая
                    </option>
                    <option value="В работе" {{ $aplication->status === 'В работе' ? 'selected' : '' }}>
                        В работе
                    </option>
                    <option value="Отказ" {{ $aplication->status === 'Отказ' ? 'selected' : '' }}>
                        Отказ
                    </option>
                    <option value="Обработана" {{ $aplication->status === 'Обработана' ? 'selected' : '' }}>
                        Обработана
                    </option>
                </select>
                <button type="submit">
                    Изменить
                </button>
            </form>
        @endforeach        
    </div>

</section>
</x-layout>