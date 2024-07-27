<?php

require 'vendor/autoload.php';

use CommissionCalculator\Calculator;

if ($argc !== 2) {
    echo "Usage: php script.php <input_file>\n";
    exit(1);
}

$inputFile = $argv[1];
$calculator = new Calculator();
$commissions = $calculator->calculateCommission($inputFile);

foreach ($commissions as $commission) {
    echo $commission . "\n";
}
