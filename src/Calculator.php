<?php

namespace CommissionCalculator;

class Calculator
{
    private $depositCalculator;
    private $privateWithdrawCalculator;
    private $businessWithdrawCalculator;
    private $exchangeRateService;

    public function __construct()
    {
        $this->depositCalculator = new DepositCalculator();
        $this->privateWithdrawCalculator = new PrivateWithdrawCalculator();
        $this->businessWithdrawCalculator = new BusinessWithdrawCalculator();
        $this->exchangeRateService = new ExchangeRateService();
    }

    public function calculateCommission(string $filePath): array
    {
        $rows = array_map('str_getcsv', file($filePath));
        $commissions = [];

        foreach ($rows as $row) {
            list($date, $userId, $userType, $operationType, $amount, $currency) = $row;

            if ($operationType === 'deposit') {
                $commissions[] = $this->depositCalculator->calculate($amount, $currency);
            } elseif ($operationType === 'withdraw') {
                if ($userType === 'private') {
                    $commissions[] = $this->privateWithdrawCalculator->calculate($date, $userId, $amount, $currency, $this->exchangeRateService);
                } elseif ($userType === 'business') {
                    $commissions[] = $this->businessWithdrawCalculator->calculate($amount, $currency);
                }
            }
        }

        return $commissions;
    }
}
