<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\ProperNameFormat;
use App\Rules\AgeLimit;
use \Illuminate\Validation\ValidationException;
use \Illuminate\Contracts\Validation\Validator;
use \Illuminate\Http\RedirectResponse;


/**
 * Класс валидации данных на запись заявки в db
 *
 * @package App\Http\Requests
 */
class StoreProjectRequest extends FormRequest
{

    /**
     * При ошибке вернет все нужное(добавил withFragment())
     * @param  \Illuminate\Contracts\Validation\Validator $validator 
     *
     * @return RedirectResponse
     */
    protected function failedValidation(Validator $validator): RedirectResponse
    {
        throw new ValidationException(
            $validator,
            redirect()
                ->route('showeHome')
                ->withErrors($validator)
                ->withInput()
                ->withFragment('home__form')
        );
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', new ProperNameFormat],
            'email' => ['required', 'email'],
            'number' => ['required', 'regex:/^\+7\s?\(\d{3}\)-\s?\d{3}-\d{2}-\d{2}$/'],
            'student_name' => ['required', new ProperNameFormat],
            'student_birth_date' => ['required', 'date', new AgeLimit(null, 18, 'student')],
            'branch_id' => 'required|exists:branches,id',
        ];
    }


    /**
     * Кастомные сообщения
     * 
     * @return array<mixed>
     */
    public function messages(): array
    {
        return [
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
    }
}
