<?php

namespace App\Components\Containers;

use App\Components\Input\Containers\InputContainer;
use App\Components\Input\InputInterface;
use App\Components\Output\OutputInterface;
use App\Components\PrimeMultiplication\PrimeMultiplicationTable;
use App\Components\Storage\StorageInterface;

/**
 * Holds and generates all configured classes from configuration.php
 */
class ConfigurationContainer
{
    protected InputContainer $inputContainerObject;
    protected InputInterface $inputObject;
    protected OutputInterface $outputObject;
    protected StorageInterface $storageObject;
    protected PrimeMultiplicationTable $primeMultiplicationTable;

    public function __construct(protected $configuration)
    {
    }


    public function getInputContainerObject(): InputContainer
    {
        if (isset($this->inputContainerObject)) {
            return $this->inputContainerObject;
        }

        $inputParameters = new $this->configuration['classes']['defaultInputParametersClass']();

        foreach ($this->configuration['options']['default'] as $key => $value) {
            $inputParameters->offsetSet($key, $value);
        }

        $this->inputContainerObject = new InputContainer($inputParameters, new $this->configuration['classes']['defaultViolationsClass']());

        return $this->inputContainerObject;
    }

    public function getInputObject($inputType = null): InputInterface
    {
        if (isset($this->inputObject)) {
            return $this->inputObject;
        }

        $defaultOption = $this->configuration['options']['input'][$this->configuration['options']['default']['input']];

        $this->inputObject = new ($this->configuration['options']['input'][$inputType] ?? $defaultOption)();

        return $this->inputObject;
    }

    public function getOutputObject($outputType = null): OutputInterface
    {
        if (isset($this->outputObject)) {
            return $this->outputObject;
        }

        $defaultOption = $this->configuration['options']['output'][$this->configuration['options']['default']['output']];

        $this->outputObject =  new ($this->configuration['options']['output'][$outputType] ?? $defaultOption)();

        return $this->outputObject;
    }

    public function getStorageObject($mockObject = null): StorageInterface
    {
        if (isset($this->storageObject)) {
            return $this->storageObject;
        }

        $storageConfig = $this->configuration['storages'][$this->configuration['currentStorage']];
        $this->storageObject =  new $storageConfig['class']($storageConfig['config'], $mockObject);

        return $this->storageObject;
    }

    public function getPrimeMultiplicationTable(string $operationOption = null): PrimeMultiplicationTable
    {
        if (isset($this->primeMultiplicationTable)) {
            return $this->primeMultiplicationTable;
        }

        $defaultOption = $this->configuration['options']['operation'][$this->configuration['options']['default']['operation']];

        $this->primeMultiplicationTable = new PrimeMultiplicationTable(
            new ($this->configuration['options']['operation'][$operationOption] ?? $defaultOption)(),
            new $this->configuration['classes']['defaultPrimeGenerator'](),
            new $this->configuration['classes']['defaultOperationTable'](),
        );

        return $this->primeMultiplicationTable;
    }
}
