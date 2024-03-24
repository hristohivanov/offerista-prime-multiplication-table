<?php

namespace App\Tests\Components\Storage;

use App\Components\Storage\MySQLStorage;
use App\Components\Storage\StorageInterface;
use PDOStatement;
use PHPUnit\Framework\TestCase;

class MySQLStorageTest extends TestCase
{
    protected MySQLStorage $storageObject;
    public function setUp(): void
    {
        parent::setUp();
        $this->storageObject = new MySQLStorage([], $this->getPDOMock());

    }

    public function testSaveData()
    {
        $result = $this->storageObject->saveData([['', 2, 3], [2, 4, 6], [3, 6, 9]]);
        var_dump($result);
        self::assertSame(true, $result);
    }

    protected function getPDOMock()
    {
        $mockPDO = $this->getMockBuilder(\PDO::class)
            ->disableOriginalConstructor()
            ->getMock();

        // Create a mock PDOStatement object
        $mockStatement = $this->getMockBuilder(PDOStatement::class)
            ->getMock();

        // Configure the mock PDO object to return the mock PDOStatement object
        $mockPDO->expects($this->once())
            ->method('prepare')
            ->willReturn($mockStatement);

        return $mockPDO;
    }
}
