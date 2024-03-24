<?php

namespace App\Components\Input;

use App\Components\Input\Containers\InputContainer;

/**
 * The standard Console Input
 */
class ConsoleInput implements InputInterface
{
    public function getInput(InputContainer $inputContainer, array $argv): InputContainer
    {
        $violations = $inputContainer->getViolations();

        if ($this->validate($argv, $violations)) {
            return $inputContainer;
        }

        $inputParameters = $inputContainer->getInputParameters();

        $inputParameters->setCount((int)$argv[0]);

        foreach ($argv as $argument) {
            if (str_starts_with($argument, '--'))   {
                $argumentSegments = explode('=', $argument);
                $inputParameters->offsetSet(substr($argumentSegments[0], 2), $argumentSegments[1] ?? null);
            }
        }

        return $inputContainer;
    }

    protected function validate($argv, $violations): bool
    {
        if (!isset($argv[0])) {
            $violations->addViolation('Is required!', 'count');
            return false;
        }

        $count = (int)$argv[0];

        if (empty($count) || $count <= 0) {
            $violations->addViolation('Must be a valid integer number greater than 0!', 'count');
        }

        return $violations->count() > 0;
    }
}