<?php 
namespace Broadpay\HostedPayments;

class Checkout
{
   
    private string $transactionName;
    private float $amount;
    private string $currency;
    private string $transactionReference;
    private string $customerEmail;
    private string $customerFirstName;
    private string $customerLastName;
    private string $customerPhone;
    private string $customerAddr;
    private string $customerCity;
    private string $customerState;
    private string $customerCountryCode;
    private string $customerPostalCode;
    private string $publicKey;
    private string $webhookUrl;
    private string $returnUrl;
    private bool $autoReturn;
    private bool $chargeMe;

    public function __construct(
        string $publicKey,
        string $transactionName,
        float $amount,
        string $currency,
        string $transactionReference,
        string $customerEmail,
        string $customerFirstName,
        string $customerLastName,
        string $customerPhone,
        string $customerAddr,
        string $customerCity,
        string $customerState,
        string $customerCountryCode,
        string $customerPostalCode,
        string $webhookUrl = '',
        string $returnUrl = '',
        bool $autoReturn = false,
        bool $chargeMe = false
    ) {
        $this->publicKey = $publicKey;
        $this->transactionName = $transactionName;
        $this->amount = $amount;
        $this->currency = $currency;
        $this->transactionReference = $transactionReference;
        $this->customerEmail = $customerEmail;
        $this->customerFirstName = $customerFirstName;
        $this->customerLastName = $customerLastName;
        $this->customerPhone = $customerPhone;
        $this->customerAddr = $customerAddr;
        $this->customerCity = $customerCity;
        $this->customerState = $customerState;
        $this->customerCountryCode = $customerCountryCode;
        $this->customerPostalCode = $customerPostalCode;
        $this->webhookUrl = $webhookUrl;
        $this->returnUrl = $returnUrl;
        $this->autoReturn = $autoReturn;
        $this->chargeMe = $chargeMe;
    }

    public function createCheckoutLink(): string
    {
        $data = [
            "transactionName" => $this->transactionName,
            "amount" => $this->amount,
            "currency" => $this->currency,
            "transactionReference" => $this->transactionReference,
            "customerFirstName" => $this->customerFirstName,
            "customerLastName" => $this->customerLastName,
            "customerEmail" => $this->customerEmail,
            "customerPhone" => $this->customerPhone,
            "customerAddr" => $this->customerAddr,
            "customerCity" => $this->customerCity,
            "customerState" => $this->customerState,
            "customerCountryCode" => $this->customerCountryCode,
            "customerPostalCode" => $this->customerPostalCode,
            "merchantPublicKey" => $this->publicKey,
            "webhookUrl" => $this->webhookUrl,
            "returnUrl" => $this->returnUrl,
            "autoReturn" => $this->autoReturn,
            "chargeMe" => $this->chargeMe,
        ];

        $ch = curl_init('https://checkout.broadpay.io/gateway/api/v1/checkout');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);

        return $response;
    }
        

}