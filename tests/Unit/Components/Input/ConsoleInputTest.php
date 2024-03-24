<?php

namespace Unit\Components\Input;

use App\Components\Input\ConsoleInput;
use App\Components\Input\Containers\InputContainer;
use App\Components\Input\InputParameters\InputParameters;
use App\Components\Input\Violations\Violations;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class ConsoleInputTest extends TestCase
{
    protected ConsoleInput $consoleInput;
    protected InputContainer $inputContainer;

    public function setUp(): void
    {
        parent::setUp();

        $this->consoleInput = new ConsoleInput();
        $this->inputContainer = new InputContainer(new InputParameters(), new Violations());
    }

    public function testGetInput()
    {
        $count = 1;
        $result = $this->consoleInput->getInput($this->inputContainer, [$count]);

        self::assertInstanceOf(InputContainer::class, $result);

        $violations = $result->getViolations();

        self::assertEquals(0, $violations->count());

        $inputParameters = $result->getInputParameters();

        self::assertEquals(1, $inputParameters->getCount());
    }

    public static function badInputsProvider(): array
    {
        return [
            'Empty input' => [['']],
            'Count Invalid Input Negative' => [[-2]],
            'Count Invalid Input String' => [['abc']],
            'Count Invalid Input Negative String' => [['-1']]
        ];
    }

    #[DataProvider('badInputsProvider')]
    public function testValidateBadInput($argument)
    {
        $result = $this->consoleInput->getInput($this->inputContainer, $argument);

        self::assertInstanceOf(InputContainer::class, $result);

        $violations = $result->getViolations();

        self::assertInstanceOf(Violations::class, $violations);


        self::assertGreaterThan(0, $violations->count());
    }
}
