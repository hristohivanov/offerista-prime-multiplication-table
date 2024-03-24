<?php

namespace App\Components\PrimeMultiplication\OperationTable\Operators;

class AdditionOperation implements OperatorInterface
{

    public function calculate($row, $column): int|float
    {
        return $row + $column;
    }
}