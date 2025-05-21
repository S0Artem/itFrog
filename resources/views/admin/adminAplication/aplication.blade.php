<x-layout>
@vite(['resources/views/admin/adminAplication/aplication.css'])
<section class="admin__aplication__section">
    <h2>Заявки</h2>
    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="aplication">
        @foreach ($aplications as $aplication)
            <div id="aplication_{{ $aplication->id }}" class="aplication__card">
                <div class="aplication__info">
                    <h4>Родитель</h4>
                    <p><strong>ФИО:</strong> {{ $aplication->name ?? 'нету инфы' }}</p>
                    <p><strong>Почта:</strong> {{ $aplication->email ?? 'нету инфы' }}</p>
                    <p><strong>Телефон:</strong> {{ $aplication->number ?? 'нету инфы' }}</p>
                    <h4>Ребенок</h4>
                    <p><strong>ФИО:</strong> {{ $aplication->student_name ?? 'нету инфы' }}</p>
                    <p><strong>Возраст:</strong> {{ $aplication->age_text }}</p>
                    <p><strong>Филиал:</strong> {{ $aplication->branche->sity}} {{ $aplication->branche->adres }}</p>
                </div>
                @if ($errors->has('aplication_' . $aplication->id))
                <div class="error">
                    {{ $errors->first('aplication_' . $aplication->id) }}
                </div>
                @endif
                
                @if (session('success_' . $aplication->id))
                    <div class="alert alert-danger ">
                        {{ session('success_' . $aplication->id) }}
                    </div>
                @endif
                <form action="{{ route('aplicationChange', $aplication->id) }}" method="post" class="aplication__form">
                    @csrf
                    @method('PATCH')
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
                        <a href="{{ route('showeRegisterUser', [
                            'email' => $aplication->email, 
                            'name' => $aplication->name, 
                            'number' => $aplication->number,
                            'idAplication' => $aplication->id
                        ]) }}" class="aplication__button">Зарегистрировать</a>
                    @elseif ($aplication->status === 'Созданная')
                        <a href="{{ route('showeRegisterStudent', [
                            'student_birth_date' => $aplication->student_birth_date, 
                            'student_name' => $aplication->student_name,
                            'branche_id' => $aplication->branche_id,
                        ]) }}" class="aplication__button">Зарегистрировать ребенка</a>
                    @endif
                </form>
            </div>
        @endforeach        
    </div>
</section>
</x-layout>