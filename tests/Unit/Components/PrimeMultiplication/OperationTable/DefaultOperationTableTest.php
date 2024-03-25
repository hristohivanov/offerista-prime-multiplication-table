<?php

namespace Unit\Components\PrimeMultiplication\OperationTable;

use App\Components\PrimeMultiplication\OperationTable\DefaultOperationTable;
use App\Components\PrimeMultiplication\OperationTable\OperationTableInterface;
use App\Components\PrimeMultiplication\OperationTable\Operators\AdditionOperation;
use App\Components\PrimeMultiplication\OperationTable\Operators\ExponentiationOperation;
use App\Components\PrimeMultiplication\OperationTable\Operators\MultiplicationOperation;
use App\Tests\Unit\AbstractUnitTestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class DefaultOperationTableTest extends AbstractUnitTestCase
{
    public static function operationProvider(): \Generator
    {
        yield [[2, 3], new MultiplicationOperation(), [[null, 2, 3], [2, 4, 6], [3, 6, 9]]];
        yield [[2, 3], new AdditionOperation(), [[null, 2, 3], [2, 4, 5], [3, 5, 6]]];
        yield [[2, 3], new ExponentiationOperation, [[null, 2, 3], [2, 4, 8], [3, 9, 27]]];
    }

    #[DataProvider('operationProvider')]
    public function testGenerateOperationTable($primeNumbers, $operation, $expectedResult)
    {
        $operationTable = new DefaultOperationTable();
        $result = $operationTable->generateOperationTable($primeNumbers, $operation);
        $result = iterator_to_array($result);

        self::assertIsIterable($result);
        self::assertEqualsCanonicalizing($expectedResult, $result);
    }
}
