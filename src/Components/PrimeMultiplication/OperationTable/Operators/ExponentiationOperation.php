<?php

namespace App\Components\PrimeMultiplication\OperationTable\Operators;

class ExponentiationOperation implements OperatorInterface
{

    public function calculate($row, $column): int|float
    {
        return $row ** $column;
    }
}