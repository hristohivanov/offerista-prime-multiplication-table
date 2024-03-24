<?php
namespace App\Components\PrimeMultiplication;

use App\Components\PrimeMultiplication\OperationTable\DefaultOperationTable;
use App\Components\PrimeMultiplication\OperationTable\OperationTableInterface;
use App\Components\PrimeMultiplication\OperationTable\Operators\AdditionOperation;
use App\Components\PrimeMultiplication\OperationTable\Operators\OperatorInterface;
use App\Components\PrimeMultiplication\PrimeGenerator\DefaultPrimeNumberGenerator;
use App\Components\PrimeMultiplication\PrimeGenerator\PrimeGeneratorInterface;
use Exception;

class PrimeMultiplicationTable
{
    public function __construct(
        protected OperatorInterface $operation = new AdditionOperation(),
        protected PrimeGeneratorInterface $primeGenerator = new DefaultPrimeNumberGenerator(),
        protected OperationTableInterface $operationTable = new DefaultOperationTable()
    )
    {
    }

    /**
     * @throws Exception
     */
    public function generate(int $count): iterable
    {
        return $this->operationTable->generateOperationTable($this->primeGenerator->generatePrimes($count), $this->operation);
    }

    public function getOperation(): OperatorInterface
    {
        return $this->operation;
    }

    public function getPrimeGenerator(): PrimeGeneratorInterface
    {
        return $this->primeGenerator;
    }

    public function getOperationTable(): OperationTableInterface
    {
        return $this->operationTable;
    }


}