<?php

namespace CommissionCalculator;

use GuzzleHttp\Client;

class ExchangeRateService
{
    private $rates;

    public function __construct()
    {
        $this->fetchExchangeRates();
    }

    private function fetchExchangeRates(): void
    {
        $url = "https://developers.paysera.com/tasks/api/currency-exchange-rates";

        $client = new Client();
        $response = $client->get($url);
        $data = json_decode($response->getBody(), true);

        if (isset($data['base']) && $data['base'] === 'EUR' && isset($data['rates'])) {
            $this->rates = $data['rates'];
        } else {
            throw new \Exception('Failed to fetch exchange rates');
        }
    }

    public function convertToEur(float $amount, string $currency): float
    {
        if (!isset($this->rates[$currency])) {
            throw new \Exception("Currency {$currency} not supported");
        }

        return $amount / $this->rates[$currency];
    }

    public function convertFromEur(float $amount, string $currency): float
    {
        if (!isset($this->rates[$currency])) {
            throw new \Exception("Currency {$currency} not supported");
        }

        return $amount * $this->rates[$currency];
    }
}
