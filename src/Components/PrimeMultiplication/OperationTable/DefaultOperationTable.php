<?php

namespace App\Components\PrimeMultiplication\OperationTable;

use App\Components\PrimeMultiplication\OperationTable\Operators\OperatorInterface;
use Exception;

class DefaultOperationTable implements OperationTableInterface
{
    public function generateOperationTable($numberList, OperatorInterface $operation): iterable
    {
        yield [...[null], ...$numberList]; //First row defined

        foreach ($numberList as $rowPrime) {
            $row = [$rowPrime];
            foreach ($numberList as $columnPrime) {
                $row[] = $operation->calculate($rowPrime, $columnPrime);
            }

            yield $row;
        }


    }
}