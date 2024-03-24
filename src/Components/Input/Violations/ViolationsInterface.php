<?php

namespace App\Components\Input\Violations;

use IteratorAggregate;

/**
 * Saves list of all occurred validation violations.
 */
interface ViolationsInterface extends IteratorAggregate
{
    public function addViolation(string $message, $inputName = null): self;

    public function count();
}