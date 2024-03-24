<?php

namespace App;

use App\Components\CLI;
use App\Components\Containers\ConfigurationContainer;
use App\Components\PrimeMultiplication\PrimeMultiplicationTable;

class CommandController
{

    public function __construct(
        protected ConfigurationContainer $configurationContainer
    )
    {
    }

    public function primeNumberGenerator($argv): void
    {
        $inputContainer = $this->configurationContainer->getInputContainerObject();

        //Todo getInput parameter from $argV
        $inputContainer = $this->configurationContainer->getInputObject()->getInput($inputContainer, $argv);


        if ($inputContainer->getViolations()->count() > 0) {
            foreach ($inputContainer->getViolations() as $violation)     {
                CLI::writeLine((($violation['inputName'] . ': ') ?? '') . $violation['message']);
            }
            return;
        }

        $inputParameters = $inputContainer->getInputParameters();

        $primeMultiplicationTable = $this->configurationContainer->getPrimeMultiplicationTable($inputParameters->getOperation());

        $resultData = iterator_to_array($primeMultiplicationTable->generate($inputParameters->getCount()));

        $output = $this->configurationContainer->getOutputObject($inputParameters->getOutput());
        $output->output($resultData);

        if ($this->configurationContainer->getStorageObject()->saveData($resultData)) {
            CLI::writeLine("Saving Success!");
        }
    }

    public function setup(): void
    {
        if ($this->configurationContainer->getStorageObject()->setUp()) {
            CLI::writeLine("Generation Success!");
        }

    }
}