<?php

namespace CommissionCalculator;

class PrivateWithdrawCalculator extends WithdrawCalculator
{
    const FEE_PERCENTAGE = 0.003;
    const FREE_AMOUNT_EUR = 1000.00;
    const FREE_OPERATIONS = 3;

    private $weeklyWithdrawals = [];

    public function calculate(string $date, int $userId, float $amount, string $currency, ExchangeRateService $exchangeRateService): string
    {
        $weekNumber = date('oW', strtotime($date));
        if (!isset($this->weeklyWithdrawals[$userId])) {
            $this->weeklyWithdrawals[$userId] = [];
        }

        if (!isset($this->weeklyWithdrawals[$userId][$weekNumber])) {
            $this->weeklyWithdrawals[$userId][$weekNumber] = [
                'count' => 0,
                'amount' => 0.00
            ];
        }

        $this->weeklyWithdrawals[$userId][$weekNumber]['count']++;

        $amountInEur = $exchangeRateService->convertToEur($amount, $currency);

        if ($this->weeklyWithdrawals[$userId][$weekNumber]['count'] <= self::FREE_OPERATIONS) {
            if ($this->weeklyWithdrawals[$userId][$weekNumber]['amount'] + $amountInEur <= self::FREE_AMOUNT_EUR) {
                $this->weeklyWithdrawals[$userId][$weekNumber]['amount'] += $amountInEur;
                return $this->roundUp(0, $currency);
            } else {
                $exceededAmount = $this->weeklyWithdrawals[$userId][$weekNumber]['amount'] + $amountInEur - self::FREE_AMOUNT_EUR;
                $this->weeklyWithdrawals[$userId][$weekNumber]['amount'] = self::FREE_AMOUNT_EUR;
                $feeInEur = $exceededAmount * self::FEE_PERCENTAGE;
            }
        } else {
            $feeInEur = $amountInEur * self::FEE_PERCENTAGE;
        }

        $fee = $exchangeRateService->convertFromEur($feeInEur, $currency);
        return $this->roundUp($fee, $currency);
    }
}
