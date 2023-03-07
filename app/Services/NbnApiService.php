<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class NbnApiService
{
    private $url = 'https://fake-nbn-portal.com/api/v2';

    private string $apiKey;

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function submitOrders($applicationId, $planId, $address)
    {
        $url = $this->url . '/order/';

        return Http::withToken($this->apiKey)->post($url, ['our_ref' => $applicationId, 'plan' => $planId, 'address' => $address]);
    }

    public function retrieveOrder(string $orderId)
    {
        $url = $this->url . '/order/' . $orderId;

        return Http::withToken($this->apiKey)->get($url);
    }
}
