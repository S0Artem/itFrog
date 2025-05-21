<x-layout>
    @vite(['resources/views/profil/profil.css'])
    <div class="info">
        @if (Auth::user()->role === 'user')
            <h2>Профиль родителя</h2>
        @elseif (Auth::user()->role === 'teacher')
            <h2>Профиль учителя</h2>
        @elseif (Auth::user()->role === 'admin')
            <h2>Профиль админа</h2>
        @endif
        <p><strong>Имя: </strong>{{ $userInfo->name }}</p>
        <p><strong>Почта: </strong>{{ $userInfo->email }}</p>
        <p><strong>Номер: </strong>{{ $userInfo->number }}</p>
    </div>
    @if (Auth::user()->role === 'user')
        <h2>Ваши дети:</h2>
        @foreach ($userStudents as $userStudent)
            <div class="student-card">
                <p><strong>Имя ребенка: </strong>{{ $userStudent->name }}</p>
                <p><strong>День рождения: </strong>{{ $userStudent->birthdate }}</p>
                @if($userStudent->branch)
                    <p><strong>Филиал: </strong>
                        {{ $userStudent->branch->sity }}, {{ $userStudent->branch->adres }}
                    </p>
                @endif
                <h4>Группа:</h4>
                @forelse($userStudent->groups as $group)
                    <div class="group-info">
                        <p><strong>Модуль: </strong>{{ $group->modul->name }}</p>
                        <p><strong>День недели: </strong>
                            @switch($group->day)
                                @case(1) Понедельник @break
                                @case(2) Вторник @break
                                @case(3) Среда @break
                                @case(4) Четверг @break
                                @case(5) Пятница @break
                                @case(6) Суббота @break
                                @case(7) Воскресенье @break
                            @endswitch
                        </p>
                        <p><strong>Время занятий: </strong>{{ $group->time->lesson_start }} - {{ $group->time->lesson_end }}</p>
                        <p><strong>Перерыв: </strong>{{ $group->time->break_start }} - {{ $group->time->break_end }}</p>

                        @foreach($group->teachers as $teacher)
                        <p>
                            <strong>Преподаватель: </strong>{{ $teacher->user->name }} 
                            <a 
                                href="https://wa.me/{{ str_replace(['+', '(', ')', '-', ' '], '', $teacher->user->number) }}" 
                                target="_blank" 
                                rel="noopener noreferrer">
                                {{ $teacher->user->number }}
                            </a>
                        </p>
                        <p>
                            <strong>Дата последней оплаты:</strong>
                            <span style="color: {{ $group->payment_color }}">
                                {{ $group->payment_display }}
                            </span>
                        </p>
                        <form action="{{ route('payment.create') }}" method="POST" class="payment-form">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                            <input type="hidden" name="student_id" value="{{ $userStudent->id }}">
                            <input type="hidden" name="amount" value="3400.00">
                            <input type="hidden" name="description" value="Оплата за обучение">
                            <input type="hidden" name="cash" value="0">
                            <input type="hidden" name="groupId" value="{{ $group->id }}">


                            <button type="submit"
                                    @if(!($group->show_button ?? false)) style="display: none;" @endif
                                    @disabled(!($group->show_button ?? false))  style="width: 200px;" class="btn">
                                <i class="fas fa-credit-card mr-2"></i> Оплатить через ЮKassa
                            </button>
                        </form>

                        @endforeach
                    </div>
                @empty
                    <p>Студент не записан ни в одну группу</p>
                @endforelse
            </div>
        @endforeach
    @endif
</x-layout>