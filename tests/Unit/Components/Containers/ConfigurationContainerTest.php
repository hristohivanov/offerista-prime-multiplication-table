<?php

namespace App\Tests\Components\Containers;

use App\Components\Containers\ConfigurationContainer;
use App\Components\Input\ConsoleInput;
use App\Components\Input\Containers\InputContainer;
use App\Components\Input\InputInterface;
use App\Components\Input\InputParameters\InputParameters;
use App\Components\Input\Violations\Violations;
use App\Components\Output\ConsoleOutput;
use App\Components\Output\OutputInterface;
use App\Components\PrimeMultiplication\OperationTable\DefaultOperationTable;
use App\Components\PrimeMultiplication\OperationTable\OperationTableInterface;
use App\Components\PrimeMultiplication\OperationTable\Operators\AdditionOperation;
use App\Components\PrimeMultiplication\OperationTable\Operators\ExponentiationOperation;
use App\Components\PrimeMultiplication\OperationTable\Operators\MultiplicationOperation;
use App\Components\PrimeMultiplication\OperationTable\Operators\OperatorInterface;
use App\Components\PrimeMultiplication\PrimeGenerator\DefaultPrimeNumberGenerator;
use App\Components\PrimeMultiplication\PrimeGenerator\PrimeGeneratorInterface;
use App\Components\PrimeMultiplication\PrimeMultiplicationTable;
use App\Components\Storage\MySQLStorage;
use App\Components\Storage\StorageInterface;
use Generator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class ConfigurationContainerTest extends TestCase
{
    protected ConfigurationContainer $configurationContainer;
    public function setUp(): void
    {
        parent::setUp();

        $this->configurationContainer = new ConfigurationContainer([
            'storages' => [
                'mysql' => [
                    'class' => MySQLStorage::class,
                    'config' => [
                        'dsn' => 'mysql:host=127.0.0.1:33066;dbname=prime_multiplication',
                        'username' => 'user',
                        'password' => 'secret',
                    ]
                ],
            ],

            'options' => [
                'operation' => [
                    'multiply' => MultiplicationOperation::class,
                    'add' => AdditionOperation::class,
                    'exponent' => ExponentiationOperation::class,
                ],

                'input' => [
                    'console' => ConsoleInput::class
                ],

                'output' => [
                    'console' => ConsoleOutput::class
                ],

                'default' => [
                    'input' => 'console',
                    'output' => 'console',
                    'operation' => 'multiply',
                ]

            ],

            'classes' => [
                'defaultPrimeGenerator' => DefaultPrimeNumberGenerator::class,
                'defaultOperationTable' => DefaultOperationTable::class,

                'defaultInputParametersClass' => InputParameters::class,
                'defaultViolationsClass' => Violations::class,
            ],

            'currentStorage' => 'mysql',
        ]);
    }

    public static function methodInstanceProvider(): Generator
    {
        yield ['getInputContainerObject', InputContainer::class];
        yield ['getInputObject', InputInterface::class];
        yield ['getOutputObject', OutputInterface::class];
    }

    #[DataProvider('methodInstanceProvider')]
    public function testRightInstanceReturned($method, $instance)
    {
        $result = $this->configurationContainer->{$method}();

        self::assertInstanceOf($instance, $result);
    }

    public function testGetPrimeMultiplicationTable()
    {
        $result = $this->configurationContainer->getPrimeMultiplicationTable();

        self::assertInstanceOf(PrimeMultiplicationTable::class, $result);
        self::assertInstanceOf(OperationTableInterface::class, $result->getOperationTable());
        self::assertInstanceOf(PrimeGeneratorInterface::class, $result->getPrimeGenerator());
        self::assertInstanceOf(OperatorInterface::class, $result->getOperation());
    }

    public function testGetStorageObject()
    {
        $mockPDO = $this->getMockBuilder(\PDO::class)
            ->disableOriginalConstructor()
            ->getMock();

        $result = $this->configurationContainer->getStorageObject($mockPDO);

        self::assertInstanceOf(StorageInterface::class, $result);
    }

}
