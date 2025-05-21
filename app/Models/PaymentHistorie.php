<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentHistorie extends Model
{
    protected $fillable = [
        'user_id',
        'student_id',
        'amount',
        'paid_at',
        'cash',
        'status',
        'payment_id', // Добавлено
        'metadata'    // Добавлено
    ];
    protected $casts = [
        'metadata' => 'array', // Автоматическое преобразование JSON ↔ array
        'cash' => 'boolean',
        'paid_at' => 'datetime',
        'amount' => 'decimal:2'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }
}
