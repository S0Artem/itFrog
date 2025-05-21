<?php

namespace App\Http\Controllers;

use App\Models\PaymentHistorie;
use App\Services\YooKassaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\ModulStudent;
use App\Models\Student;

class PaymentController extends Controller
{
    public function create(Request $request, YooKassaService $yooKassa)
    {
        $validated = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'student_id' => 'required|integer|exists:students,id',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'required|string|max:255',
            'cash' => 'required|boolean',
            'groupId' => 'required'
        ]);

        DB::beginTransaction();
        
        try {
            // Формируем URL для возврата с параметрами
            $returnUrl = route('payment.callback', [
                'user_id' => $validated['user_id'],
                'student_id' => $validated['student_id']
            ]);

            $payment = $yooKassa->createPayment(
                amount: (float)$validated['amount'],
                description: $validated['description'],
                metadata: [
                    'user_id' => $validated['user_id'],
                    'student_id' => $validated['student_id'],
                    'cash' => $validated['cash']
                ],
                returnUrl: $returnUrl
            );
            $student = Student::find($validated['student_id']);
            $groupId = $validated['groupId']; // получи нужный group_id

            $student->groups()->updateExistingPivot($groupId, [
                'last_payment_date' => now(),
            ]);
            // Сохраняем платеж в БД перед перенаправлением
            PaymentHistorie::create([
                'user_id' => $validated['user_id'],
                'student_id' => $validated['student_id'],
                'amount' => $validated['amount'],
                'payment_id' => $payment['id'],
                'status' => 'confirmed',
                'paid_at' => now(),
                'cash' => $validated['cash'],
                'metadata' => [ // Теперь передаем массив, а не JSON-строку
                    'description' => $validated['description'],
                    'yookassa_response' => $payment
                ]
            ]);
            

            DB::commit();
            
            return redirect()->away($payment['confirmation']['confirmation_url']);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Payment creation failed: '.$e->getMessage());
            return back()->with('error', 'Ошибка при создании платежа');
        }
    }

    public function callback(Request $request, YooKassaService $yooKassa)
    {
        // Получаем payment_id из URL (ЮKassa добавит его в параметры)
        $paymentId = $request->input('payment_id');
        
        if (!$paymentId) {
            Log::error('Missing payment_id in callback', $request->all());
            return redirect()->route('showeProfil')->with('error', 'Не удалось идентифицировать платеж');
        }

        try {
            // Проверяем статус платежа через API
            $payment = $yooKassa->checkPaymentStatus($paymentId);
            
            // Обновляем запись в БД
            $status = $this->mapStatus($payment['status'] ?? 'unknown');
            
            PaymentHistorie::where('payment_id', $paymentId)->update([
                'status' => $status,
                'paid_at' => $status === 'confirmed' ? now() : null,
                'metadata->callback_data' => $payment
            ]);

            return redirect()->route('showeProfil')
                   ->with('payment_status', $status);
                   
        } catch (\Exception $e) {
            Log::error('Payment callback error: '.$e->getMessage());
            return redirect()->route('showeProfil')
                   ->with('error', 'Ошибка обработки платежа');
        }
    }

    private function mapStatus(string $yookassaStatus): string
    {
        return match($yookassaStatus) {
            'succeeded' => 'confirmed',
            'canceled' => 'rejected',
            'pending', 'waiting_for_capture' => 'pending',
            default => 'unknown'
        };
    }
}