<?php

namespace Broadpay\Queries;

use \Firebase\JWT\JWT;

class TransactionQuery
{
    // Declare private variables
    private string $privateKey;
    private string $publicKey;

    // Constructor to initialize the class properties
    public function __construct(
        string $privateKey,
        string $publicKey,
    ) {
        $this->privateKey = $privateKey;
        $this->publicKey = $publicKey;
    }

    // Method to query the transaction
    public function queryTransaction(string $transactionReference): string
    {
        // Encode the payload
        $token = $this->encodePayload();

        // Initialize cURL
        $ch = curl_init();

        // Append parameters to the URL
        $queryParams = [
            'merchantReference' => $transactionReference,
        ];
        $url = 'https://live.broadpay.io/gateway/api/v1/transaction/query?' . http_build_query($queryParams);

        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // Set HTTP headers
        $headers = [
            'token: ' . $token,
            'Content-Type: application/json',
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // Execute the cURL request
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        
        // Return the result
        return $result;

    }

    // Method to encode the payload
    private function encodePayload(): string
    {
        // Prepare the data
        $data = [
            "pubKey" => $this->publicKey,
        ];

        // Encode the data into a JWT
        $token = JWT::encode($data, $this->privateKey, 'HS256');

        // Return the token
        return $token;
    }
}