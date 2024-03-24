<?php

namespace App\Components\PrimeMultiplication\PrimeGenerator;

interface PrimeGeneratorInterface
{
    /**
     * @param int $count - How much positions to be generated.
     * @return iterable - list of all generated prime numbers. TODO future ArrayAccess Class.
     */
    public function generatePrimes(int $count): array;
}