<?php

namespace App\Components\PrimeMultiplication\OperationTable;

use App\Components\PrimeMultiplication\OperationTable\Operators\OperatorInterface;

interface OperationTableInterface
{
    public function generateOperationTable($numberList, OperatorInterface $operation): iterable;
}