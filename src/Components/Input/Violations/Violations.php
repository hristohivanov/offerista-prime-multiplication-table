<?php

namespace App\Components\Input\Violations;

use Traversable;

/**
 * Saves list of all occurred validation violations.
 */
class Violations extends AbstractViolations
{
    public function addViolation(string $message, $inputName = null): self
    {
        $this->violations[] = [
            'message' => $message,
            'inputName' => $inputName
        ];

        return $this;
    }

    public function count(): int
    {
        return count($this->violations);
    }

    public function getIterator(): Traversable
    {
        yield from $this->violations;
    }
}