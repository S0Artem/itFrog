<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Carbon\Carbon;
# TODO: разобрать и переиспользовать
class AgeLimit implements ValidationRule
{
    protected $minAge;
    protected $maxAge;
    protected $type;

    public function __construct($minAge = null, $maxAge = null, $type = 'user')
    {
        $this->minAge = $minAge;
        $this->maxAge = $maxAge;
        $this->type = $type;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $birthDate = Carbon::parse($value);
        $age = $birthDate->age;
        
        if ($this->type === 'student') {
            // Для студентов: не старше 18 лет
            if ($age > 18) {
                $fail('Возраст ученика не может быть больше 18 лет');
                return;
            }
        } else {
            // Для пользователей: не старше 120 лет
            if ($age > 120) {
                $fail('Возраст пользователя не может быть больше 120 лет');
                return;
            }
        }
        
        // Проверяем минимальный возраст, если указан
        if ($this->minAge && $age < $this->minAge) {
            $fail("Возраст должен быть не менее {$this->minAge} лет");
            return;
        }
        
        // Проверяем максимальный возраст, если указан
        if ($this->maxAge && $age > $this->maxAge) {
            $fail("Возраст должен быть не более {$this->maxAge} лет");
            return;
        }
    }
} 