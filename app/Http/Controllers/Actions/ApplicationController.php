<?php

namespace App\Http\Controllers\Actions;

use App\Models\Application;
use App\Http\Requests\ApplicationFormRequest;
use \Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;


/**
 * Класс для записи заявок в бд
 *
 * @package App\Http\Controllers\Actions
 */
class ApplicationController extends Controller
{
    /**
     * Обработка заявки
     * 
     * @param  \Illuminate\Http\Request $request Данные заявки
     *
     * @return RedirectResponse         Результат выполнения
     */
    public function store(ApplicationFormRequest $request): RedirectResponse
    {
        Application::create($request->validated());

        return redirect()
            ->route('showeHome')
            ->with('form', 'Заявка успешно отправлена!')
            ->withFragment('home__form');
    }
}
