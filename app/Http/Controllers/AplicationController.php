<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aplication;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AplicationController extends Controller
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
            'name' => ['required', 'regex:/^\s*\S+\s+\S+\s+\S+/u'],
            'email' => ['required', 'email'],
            'number' => ['required', 'regex:/^\+7\s?\(\d{3}\)-\s?\d{3}-\d{2}-\d{2}$/'],
            'student_name' => ['required', 'regex:/^\s*\S+\s+\S+\s+\S+/u'],
            'birthdate' => ['required', 'date'],
            'branch_id' => 'required|exists:branches,id',
        ], $messages);

        if ($validator->fails()) {
            return redirect()
                ->route('showeHome')
                ->withErrors($validator)
                ->withInput()
                ->withFragment('home__form');
        }

        Aplication::create([
            'name' => $request->name,
            'email' => $request->email,
            'number' => $request->number,
            'student_name' => $request->student_name,
            'student_birth_date' => $request->birthdate,
            'branche_id' => $request->branch_id,
        ]);

        return redirect()->route('showeHome')->with('form', 'Заявка успешно отправлена!')->withFragment('home__form');
    }
}
