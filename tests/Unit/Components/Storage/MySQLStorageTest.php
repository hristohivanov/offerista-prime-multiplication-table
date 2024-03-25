<?php

namespace App\Tests\Components\Storage;

use App\Components\Storage\MySQLStorage;
use PDOStatement;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class MySQLStorageTest extends TestCase
{
    public function testSaveData()
    {
        $storageObject = new MySQLStorage([], $this->getPDOMock(2));

        $result = $storageObject->saveData([['', 2, 3], [2, 4, 6], [3, 6, 9]], 'test_table');

        self::assertSame(true, $result);
    }

    protected function getPDOMock($expect): MockObject
    {
        $mockPDO = $this->getMockBuilder(\PDO::class)
            ->disableOriginalConstructor()
            ->getMock();

        $mockStatement = $this->getMockBuilder(PDOStatement::class)
            ->getMock();

        // Configure the mock PDO object to return the mock PDOStatement object
        $mockPDO->expects($this->exactly($expect))
            ->method('prepare')
            ->willReturn($mockStatement);

        return $mockPDO;
    }
}
