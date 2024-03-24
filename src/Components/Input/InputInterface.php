<?php

namespace App\Components\Input;

use App\Components\Input\Containers\InputContainer;

interface InputInterface
{
    public function getInput(InputContainer $inputContainer, array $argv): InputContainer;
}