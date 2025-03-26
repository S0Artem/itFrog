<x-layout>
@vite(['resources/views/adminAplication/aplication.css'])
<section class="admin__aplication__section">
    <h2>Заявки</h2>
    <div class="aplication">
        @foreach ($aplications as $aplication)
            <div class="aplication__card">
                <div class="aplication__info">
                    <p><strong>Имя:</strong> {{ $aplication->name ?? 'нету инфы' }}</p>
                    <p><strong>Почта:</strong> {{ $aplication->email ?? 'нету инфы' }}</p>
                    <p><strong>Телефон:</strong> {{ $aplication->number ?? 'нету инфы' }}</p>
                </div>
                <form action="{{ route('aplicationChange', $aplication->id) }}" method="post" class="aplication__form">
                    @csrf
                    @method('PATCH')
                    {{-- //TODO:на строне сервера сделать невозможность менять при созданнном пользователе --}}
                    <select name="status" id="status" class="aplication__select" onchange="this.form.submit()" {{ $aplication->status === 'Созданная' ? 'disabled' : '' }}>
                        <option value="Новая" {{ $aplication->status === 'Новая' ? 'selected' : '' }}>Новая</option>
                        <option value="В работе" {{ $aplication->status === 'В работе' ? 'selected' : '' }}>В работе</option>
                        <option value="Отказ" {{ $aplication->status === 'Отказ' ? 'selected' : '' }}>Отказ</option>
                        <option value="Обработана" {{ $aplication->status === 'Обработана' ? 'selected' : '' }}>Обработана</option>
                        @if ($aplication->status === 'Созданная')
                            <option value="Созданная" {{ $aplication->status === 'Созданная' ? 'selected' : '' }}>Созданная</option>
                        @endif
                    </select>
                    @if ($aplication->status === 'Обработана')
                        <a href="{{ route('showeAdminRegister', ['email' => $aplication->email, 'name' => $aplication->name, 'idAplication' => $aplication->id]) }}" class="aplication__button">Зарегистрировать</a>
                    @endif
                </form>
            </div>
        @endforeach        
    </div>
</section>
</x-layout>