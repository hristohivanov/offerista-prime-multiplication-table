<?php

namespace App\Components\Input\InputParameters;

interface InputParametersInterface extends \ArrayAccess
{
    public function getCount(): int;

    public function setCount($count): self;

    public function getOutput(): string;

    public function setOutput($outputType): self;

    public function getOperation(): string;

    public function setOperation($operation): self;
}