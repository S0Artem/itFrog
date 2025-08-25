<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Rules\ProperNameFormat;
use App\Rules\AgeLimit;

class ApplicationController extends Controller
{
    public function store(Request $request)
    {
        $messages = [
            'email.required' => 'Почта обязательна для заполнения',
            'email.email' => 'Пожалуйста, введите корректный адрес электронной почты',
            'email.unique' => 'Пользователь с такой почтой уже зарегистрирован',

            'name.required' => 'Имя обязательно для заполнения',
            'name.regex' => 'Введите полное ФИО (например, Софронов Артем Павлович)',

            'student_name.required' => 'Имя ребенка обязательно',
            'student_name.regex' => 'Введите полное ФИО (например, Софронов Артем Павлович)',

            'number.required' => 'Номер обязательно для заполнения',
            'number.regex' => 'Введите корректный номер телефона в формате +7 (XXX)-XXX-XX-XX',

            'branch_id.required' => 'Филиал обязательно для выбора',

            'birthdate.required' => 'Дата рождения обязательна',
            'birthdate.date' => 'Введите корректную дату рождения',
        ];

        $validator = Validator::make($request->all(), [
            'name' => ['required', new ProperNameFormat],
            'email' => ['required', 'email'],
            'number' => ['required', 'regex:/^\+7\s?\(\d{3}\)-\s?\d{3}-\d{2}-\d{2}$/'],
            'student_name' => ['required', new ProperNameFormat],
            'birthdate' => ['required', 'date', new AgeLimit(null, 18, 'student')],
            'branch_id' => 'required|exists:branches,id',
        ], $messages);

        if ($validator->fails()) {
            return redirect()
                ->route('showeHome')
                ->withErrors($validator)
                ->withInput()
                ->withFragment('home__form');
        }

        Application::create([
            'name' => $request->name,
            'email' => $request->email,
            'number' => $request->number,
            'student_name' => $request->student_name,
            'student_birth_date' => $request->birthdate,
            'branch_id' => $request->branch_id,
            'created_at' => now()->setTimezone('Europe/Moscow'),
            'updated_at' => now()->setTimezone('Europe/Moscow'),
        ]);

        return redirect()->route('showeHome')->with('form', 'Заявка успешно отправлена!')->withFragment('home__form');
    }
}
