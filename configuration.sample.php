<?php

use App\Components\Input\ConsoleInput;
use App\Components\Input\InputParameters\InputParameters;
use App\Components\Input\Violations\Violations;
use App\Components\Output\ConsoleOutput;
use App\Components\PrimeMultiplication\OperationTable\DefaultOperationTable;
use App\Components\PrimeMultiplication\OperationTable\Operators\AdditionOperation;
use App\Components\PrimeMultiplication\OperationTable\Operators\ExponentiationOperation;
use App\Components\PrimeMultiplication\OperationTable\Operators\MultiplicationOperation;
use App\Components\PrimeMultiplication\PrimeGenerator\DefaultPrimeNumberGenerator;
use App\Components\Storage\MySQLStorage;

$configuration = [
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
];

return $configuration;