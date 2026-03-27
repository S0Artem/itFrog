<?php

namespace App\Http\Controllers\Actions;

use Illuminate\Http\Request;
use App\Models\Application;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Rules\ProperNameFormat;
use App\Rules\AgeLimit;
use App\Http\Requests\StoreProjectRequest;
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
    public function store(StoreProjectRequest $request): RedirectResponse
    {
        Application::create($request->validated());

        return redirect()
            ->route('showeHome')
            ->with('form', 'Заявка успешно отправлена!')
            ->withFragment('home__form');
    }
}
