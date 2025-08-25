<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ProperNameFormat implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Разбиваем строку на слова
        $words = preg_split('/\s+/', trim($value));
        
        // Проверяем, что есть ровно 3 слова (ФИО)
        if (count($words) < 2) {
            $fail('ФИО должно содержать более двух слов (Фамилия Имя Отчество)');
            return;
        }
        
        // Проверяем каждое слово
        foreach ($words as $word) {
            // Проверяем, что слово начинается с заглавной буквы
            if (!preg_match('/^[А-ЯЁ][а-яё]*$/u', $word)) {
                $fail('Каждое слово в ФИО должно начинаться с заглавной буквы и содержать только русские буквы');
                return;
            }
        }
    }
} 