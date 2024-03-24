<?php

namespace App\Components\Output;

use App\Components\CLI;

/**
 * The standard default console output.
 */
class ConsoleOutput implements OutputInterface
{
    public function output($dataTable): void
    {
        foreach ($dataTable as $rows) {
            CLI::write(implode("\t", $rows) . PHP_EOL);
        }
    }
}