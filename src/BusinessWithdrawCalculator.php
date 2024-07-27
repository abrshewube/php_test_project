<?php

namespace CommissionCalculator;

class BusinessWithdrawCalculator extends WithdrawCalculator
{
    const FEE_PERCENTAGE = 0.005;

    public function calculate(float $amount, string $currency): string
    {
        $fee = $amount * self::FEE_PERCENTAGE;
        return $this->roundUp($fee, $currency);
    }
}
