<?php

use PHPUnit\Framework\TestCase;
use CommissionCalculator\Calculator;
use CommissionCalculator\ExchangeRateService;
use CommissionCalculator\PrivateWithdrawCalculator;
use CommissionCalculator\DepositCalculator;
use CommissionCalculator\BusinessWithdrawCalculator;

class CalculatorTest extends TestCase
{
    private $calculator;

    protected function setUp(): void
    {
        $this->calculator = new Calculator();
    }

    public function testDepositCalculation()
    {
        $depositCalculator = new DepositCalculator();
        $result = $depositCalculator->calculate(200.00, 'EUR');
        $this->assertEquals('0.06', $result);

        $result = $depositCalculator->calculate(200.00, 'JPY');
        $this->assertEquals('1', $result);  // Expected to be rounded up correctly
    }

    public function testPrivateWithdrawCalculation()
    {
        $exchangeRateService = new ExchangeRateService();
        $privateWithdrawCalculator = new PrivateWithdrawCalculator();

        $result = $privateWithdrawCalculator->calculate('2022-03-15', 1, 1000.00, 'EUR', $exchangeRateService);
        $this->assertEquals('0.00', $result);

        $result = $privateWithdrawCalculator->calculate('2022-03-15', 1, 2000.00, 'EUR', $exchangeRateService);
        $this->assertEquals('3.00', $result);

        $result = $privateWithdrawCalculator->calculate('2022-03-15', 1, 100000.00, 'JPY', $exchangeRateService);
        $this->assertEquals('8612', $result);  // Expected to convert and round correctly
    }

    public function testBusinessWithdrawCalculation()
    {
        $businessWithdrawCalculator = new BusinessWithdrawCalculator();

        $result = $businessWithdrawCalculator->calculate(500.00, 'EUR');
        $this->assertEquals('2.50', $result);

        $result = $businessWithdrawCalculator->calculate(500.00, 'JPY');
        $this->assertEquals('3', $result);  // Expected to be rounded up correctly
    }

    public function testOverallCalculation()
    {
        $inputFile = __DIR__ . '/input.csv'; 
        $expectedResults = [
            '0.60',
            '3.00',
            '0.00',
            '0.06',
            '1.50',
            '0',
            '0.70',
            '0.30',
            '0.30',
            '3.00',
            '0.00',
            '0.00',
            '8608'
        ];

        $commissions = $this->calculator->calculateCommission($inputFile);
        $this->assertEquals($expectedResults, $commissions);
    }
}

