<?php

namespace App\Components\PrimeMultiplication\OperationTable\Operators;

interface OperatorInterface
{
    public function calculate($row, $column): int|float;
}