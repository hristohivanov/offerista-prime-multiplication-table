<?php

namespace App\Components\Input\Containers;

use App\Components\Input\InputParameters\InputParametersInterface;
use App\Components\Input\Violations\AbstractViolations;

/**
 * Container with anything necessary for input functionality used in App\Components\Input\InputInterface.
 */
class InputContainer
{
    public function __construct(
        protected InputParametersInterface $inputParameters,
        protected AbstractViolations $violations
    )
    {
    }

    public function getInputParameters(): InputParametersInterface
    {
        return $this->inputParameters;
    }

    public function getViolations(): AbstractViolations
    {
        return $this->violations;
    }



}