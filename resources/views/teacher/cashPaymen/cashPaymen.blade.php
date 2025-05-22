@vite(['resources/views/teacher/cashPaymen/cashPaymen.js'])
@vite(['resources/views/teacher/cashPaymen/cashPaymen.css'])
<x-layout>

    <section class="register__section">
        
        <div class="register-container">
            <h2>Оплата наличными</h2>
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <form action="{{ route('submitCashPaymen') }}" method="post">
                @csrf
                <div class="form-group">
                    <label>Группа из вашего филиала</label>
                    <select id="group_id" class="form-control" name="group_id">
                        <option value="">Выберите группу</option>
                        @foreach($groups as $group)
                            <option value="{{ $group->id }}" {{ old('group') }}>
                                {{ $group->modul->name }} — {{ $group->id }}
                            </option>
                        @endforeach
                    </select>
                    

                </div>
                @error('group_id') <p class="error">{{ $message }}</p> @enderror
                <div class="form-group">
                    <label>Ребенок из группы</label>
                    <select id="student_id" class="form-control" name="student_id" disabled>
                        <option id="group_placeholder">Сначала выберите группу</option>
                        @foreach($students as $student)
                            @foreach($student->groups as $group)
                                <option value="{{ $student->id }}" {{ old('group') }}
                                        data-groups="{{ $student->groups->pluck('id')->join(',') }}"
                                        data-payment="{{ $group->payment_display }}"
                                        data-color="{{ $group->payment_color }}"
                                        data-group="{{ $group->id }}"
                                        hidden>
                                    {{ $student->name }}
                                </option>
                            @endforeach
                        @endforeach
                    </select>
                </div>
                @error('student_id') <p class="error">{{ $message }}</p> @enderror

                {{-- Это будет блок с текстом про оплату --}}
                <div id="payment-info" style="margin-top: 10px;"></div>


                <button type="submit" class="btn">Принял оплату</button>
            </form>
        </div>
        
    </section>
</x-layout>

