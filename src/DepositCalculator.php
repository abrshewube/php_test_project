<?php

namespace CommissionCalculator;

class DepositCalculator
{
    const FEE_PERCENTAGE = 0.0003;

    public function calculate(float $amount, string $currency): string
    {
        $fee = $amount * self::FEE_PERCENTAGE;
        return $this->roundUp($fee, $currency);
    }

    private function roundUp(float $value, string $currency): string
    {
        $precision = $this->getCurrencyPrecision($currency);
        return number_format(ceil($value * pow(10, $precision)) / pow(10, $precision), $precision, '.', '');
    }

    private function getCurrencyPrecision(string $currency): int
    {
        switch ($currency) {
            case 'JPY':
                return 0;
            case 'USD':
            case 'EUR':
            default:
                return 2;
        }
    }
}
