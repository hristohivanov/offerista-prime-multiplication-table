<?php

namespace App\Components\PrimeMultiplication\PrimeGenerator;
/**
 * Prime Number generator using Trial Division algorithm with Square Root Optimization and even number reduction
 */
class DefaultPrimeNumberGenerator implements PrimeGeneratorInterface
{
    public function generatePrimes(int $count): array
    {
        if ($count <= 0) {
            return [];
        }

        $primes = [2];

        // Check every odd number if is prime number (no need to check even numbers as they're all not prime numbers).
        for ($number = 3; count($primes) < $count; $number += 2) {
            if ($this->isPrimeNumber($number, $primes)) {
                $primes[] = $number;
            }
        }

        return $primes;
    }

    /**
     * Checks if the number is prime.
     * When determining if a number is prime, we only need to check divisibility by prime numbers less than or equal to its square root and dividing by primes.
     * This optimization reduces the number of divisions required.
     */
    protected function isPrimeNumber($number, $primeNumberList): bool
    {
        $sqrtNum = sqrt($number);

        foreach ($primeNumberList as $primeNumber) {
            if ($primeNumber > $sqrtNum) {
                break;
            }

            if ($number % $primeNumber === 0) {
                return false;
            }
        }

        return true;
    }
}