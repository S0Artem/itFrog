<?php

namespace App\Services;

use YooKassa\Client;
use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Support\Facades\Log;

class YooKassaService
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client();
        $this->client->setAuth(
            config('services.yookassa.shop_id'),
            config('services.yookassa.secret_key')
        );
    }

    public function createPayment(float $amount, string $description, array $metadata, string $returnUrl)
    {
        $client = new GuzzleClient([
            'base_uri' => 'https://api.yookassa.ru/v3/',
            'auth' => [
                config('services.yookassa.shop_id'),
                config('services.yookassa.secret_key'),
            ],
            'headers' => [
                'Content-Type' => 'application/json',
                'Idempotence-Key' => uniqid('', true),
            ],
            'verify' => app()->environment('production'),
        ]);

        try {
            $response = $client->post('payments', [
                'json' => [
                    'amount' => [
                        'value' => number_format($amount, 2, '.', ''),
                        'currency' => 'RUB',
                    ],
                    'confirmation' => [
                        'type' => 'redirect',
                        'return_url' => $returnUrl,
                    ],
                    'capture' => true,
                    'description' => $description,
                    'metadata' => $metadata,
                ]
            ]);

            $data = json_decode($response->getBody(), true);
            
            if (empty($data['id']) || empty($data['confirmation']['confirmation_url'])) {
                throw new \RuntimeException('Invalid payment response structure');
            }

            return $data;
            
        } catch (\Exception $e) {
            Log::error('YooKassa API Error: '.$e->getMessage());
            throw $e;
        }
    }

    public function checkPaymentStatus(string $paymentId): array
    {
        $client = new GuzzleClient([
            'base_uri' => 'https://api.yookassa.ru/v3/',
            'auth' => [
                config('services.yookassa.shop_id'),
                config('services.yookassa.secret_key'),
            ],
            'verify' => app()->environment('production'),
        ]);

        try {
            $response = $client->get("payments/$paymentId");
            $data = json_decode($response->getBody(), true);
            
            if (empty($data['id'])) {
                throw new \RuntimeException('Invalid payment status response');
            }
            
            return $data;
            
        } catch (\Exception $e) {
            Log::error('YooKassa Status Check Error: '.$e->getMessage());
            throw $e;
        }
    }
}