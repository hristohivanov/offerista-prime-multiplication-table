<?php
namespace Unit\Components\PrimeMultiplication;

use App\Components\PrimeMultiplication\OperationTable\OperationTableInterface;
use App\Components\PrimeMultiplication\OperationTable\Operators\AdditionOperation;
use App\Components\PrimeMultiplication\OperationTable\Operators\ExponentiationOperation;
use App\Components\PrimeMultiplication\OperationTable\Operators\MultiplicationOperation;
use App\Components\PrimeMultiplication\PrimeMultiplicationTable;
use App\Tests\Unit\AbstractUnitTestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class PrimeMultiplicationTableTest extends AbstractUnitTestCase
{

    public static function operationProvider(): \Generator
    {
        yield [2, new MultiplicationOperation(), [['', 2, 3], [2, 4, 6], [3, 6, 9]]];
        yield [2, new AdditionOperation(), [['', 2, 3], [2, 4, 5], [3, 5, 6]]];
        yield [2, new ExponentiationOperation(), [['', 2, 3], [2, 4, 8], [3, 9, 27]]];
    }

    #[DataProvider('operationProvider')]
    public function testGenerate($count, $operation, $expectedResult)
    {
        $primeMultiplicationTable = new PrimeMultiplicationTable($operation);

        $result = $primeMultiplicationTable->generate($count);
        $result = iterator_to_array($result);

        self::assertIsIterable($result);
        self::assertEqualsCanonicalizing($expectedResult, $result);
    }
}
