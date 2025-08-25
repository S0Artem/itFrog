<x-layout>
    @vite(['resources/views/profil/profil.css'])
    <div class="info">
        @if (Auth::user()->role === 'user')
            <h2>Профиль родителя</h2>
        @elseif (Auth::user()->role === 'teacher')
            <h2>Профиль учителя</h2>
            @if($branch)
            <p><strong>Филиал: </strong>{{ $branch->sity }}, {{ $branch->adres }}</p>
            @else
                <p><strong>Филиал: </strong>Не назначен</p>
            @endif
        @elseif (Auth::user()->role === 'admin')
            <h2>Профиль администратора</h2>
        @endif
        <p><strong>Имя: </strong>{{ $userInfo->name }}</p>
        <p><strong>Почта: </strong>{{ $userInfo->email }}</p>
        <p><strong>Номер: </strong>{{ $userInfo->number }}</p>
    </div>
    @if (Auth::user()->role === 'user')
        
        <h2>Ваши дети:</h2>
        @foreach ($userStudents as $userStudent)
            <div class="student-card">
                <p><strong>Имя ребёнка: </strong>{{ $userStudent->name }}</p>
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
                    <p>Ученик не записан ни в одну группу.</p>
                @endforelse
            </div>
        @endforeach
        @include('home.component.form.form')
    @elseif (Auth::user()->role === 'teacher')
        <h2>Модули, которые вы ведёте</h2>
        <div class="modules-grid">
            @foreach ($moduls as $modul)
                <div class="module-card">
                    <div class="module-header">
                        <h3>{{ $modul->name }}</h3>
                        <span class="module-lessons">{{ $modul->lesson }} занятий</span>
                    </div>
                    
                    <p class="module-description">{{ $modul->description }}</p>
                    <p class="module-age"><strong>Возраст:</strong> {{ $modul->min_age }}–{{ $modul->max_age }} лет</p>
                    
                    @if($modul->tags)
                        <div class="module-tags">
                            @foreach(json_decode($modul->tags, true) as $tag)
                                <span class="module-tag">{{ $tag }}</span>
                            @endforeach
                        </div>
                    @endif
                    
                    <div class="module-actions">
                        @if($modul->direction)
                            <a href="{{ route('direction.show', $modul->direction->id) }}" class="btn btn-primary">
                                Перейти к направлению
                            </a>
                        @endif
                        @if($modul->file)
                            <a href="{{ asset($modul->file) }}" download="{{ $modul->name }} для учителя.pdf" class="btn btn-secondary">
                                Скачать материалы
                            </a>
                        @endif
                    </div>
            </div>
            @endforeach
        </div>
    @endif
</x-layout>