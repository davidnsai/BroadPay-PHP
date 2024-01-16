<?php

namespace Broadpay\MobileMoney;

use \Firebase\JWT\JWT;

class Debit
{
    private string $privateKey;
    private string $publicKey;
    private float $amount;
    private string $currency;
    private string $customerEmail;
    private string $customerFirstName;
    private string $customerLastName;
    private string $customerPhone;
    private string $transactionName;
    private string $transactionReference;
    private string $wallet;
    private bool $chargeMe;

    public function __construct(
        string $privateKey,
        string $publicKey,
        float $amount,
        string $currency,
        string $customerEmail,
        string $customerFirstName,
        string $customerLastName,
        string $customerPhone,
        string $transactionName,
        string $transactionReference,
        string $wallet,
        bool $chargeMe = false
    ) {
        $this->privateKey = $privateKey;
        $this->publicKey = $publicKey;
        $this->amount = $amount;
        $this->currency = $currency;
        $this->customerEmail = $customerEmail;
        $this->customerFirstName = $customerFirstName;
        $this->customerLastName = $customerLastName;
        $this->customerPhone = $customerPhone;
        $this->transactionName = $transactionName;
        $this->transactionReference = $transactionReference;
        $this->wallet = $wallet;
        $this->chargeMe = $chargeMe;
    }

    public function pay()
    {
        $payload = $this->encodePayload();

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://live.broadpay.io/gateway/api/v1/momo/debit');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['payload' => $payload]));

        $headers = array();
        $headers[] = 'X-PUB-KEY: ' . $this->publicKey;
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);

        return $result;
    }

    private function encodePayload(): string
    {
        $data = [
            "amount" => $this->amount,
            "currency" => $this->currency,
            "customerEmail" => $this->customerEmail,
            "customerFirstName" => $this->customerFirstName,
            "customerLastName" => $this->customerLastName,
            "customerPhone" => $this->customerPhone,
            "merchantPublicKey" => $this->publicKey,
            "transactionName" => $this->transactionName,
            "transactionReference" => $this->transactionReference,
            "wallet" => $this->wallet,
            "chargeMe" => $this->chargeMe,
        ];

        $payload = JWT::encode($data, $this->privateKey, 'HS256');

        return $payload;
    }
}