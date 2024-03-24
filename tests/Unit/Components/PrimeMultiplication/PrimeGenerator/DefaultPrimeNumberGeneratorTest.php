<?php

namespace Unit\Components\PrimeMultiplication\PrimeGenerator;

use App\Components\PrimeMultiplication\PrimeGenerator\DefaultPrimeNumberGenerator;
use App\Tests\Unit\AbstractUnitTestCase;
use PHPUnit\Framework\Assert;

class DefaultPrimeNumberGeneratorTest extends AbstractUnitTestCase
{

    public function testGeneratePrimes()
    {
        $primeNumberGenerator = new DefaultPrimeNumberGenerator();

        $result = $primeNumberGenerator->generatePrimes(4);

        Assert::assertIsArray($result);
        Assert::assertEqualsCanonicalizing([2, 3, 5, 7], $result);
    }
}
