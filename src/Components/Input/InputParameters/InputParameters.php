<?php

namespace App\Components\Input\InputParameters;

class InputParameters implements InputParametersInterface
{
    protected int $count;

    protected string $input;

    protected string $output;

    protected string $operation;

    public function getCount(): int
    {
        return $this->count;
    }

    public function setCount($count): self
    {
        $this->count = $count;

        return $this;
    }

    public function getOutput(): string
    {
        return $this->output;
    }

    public function setOutput($outputType): self
    {
        $this->output = $outputType;

        return $this;
    }

    public function getOperation(): string
    {
        return $this->operation;
    }

    public function setOperation($operation): self
    {
        $this->operation = $operation;

        return $this;
    }

    public function offsetExists(mixed $offset): bool
    {
        return property_exists($this, $offset);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->$offset;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->$offset = $value;
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->$offset);
    }
}