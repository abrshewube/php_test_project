<?php

namespace CommissionCalculator;

class WithdrawCalculator
{
    protected function roundUp(float $value, string $currency): string
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
