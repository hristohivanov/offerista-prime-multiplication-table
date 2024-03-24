<?php

namespace App\Tests\Components\Output;

use App\Components\Output\ConsoleOutput;
use PHPUnit\Framework\TestCase;

class ConsoleOutputTest extends TestCase
{
    protected ConsoleOutput $outputObject;

    public function setUp(): void
    {
        parent::setUp();
        $this->outputObject = new ConsoleOutput();
    }

    public function testOutput()
    {
        ob_start();

        $this->outputObject->output([['', 2, 3], [2, 4, 6], [3, 6, 9]]);

        $output = ob_get_clean();

        $this->assertGreaterThan(0, strlen($output));
    }

    public function testOutputEmpty()
    {
        ob_start();

        $this->outputObject->output([]);

        $output = ob_get_clean();

        $this->assertEquals(0, strlen($output));
    }
}
