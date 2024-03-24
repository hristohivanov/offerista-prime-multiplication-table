# Prime Multiplication Table Generator

PHP program that generates a multiplication table of prime numbers.

## Requirements:

 * PHP: 8.2+ with [PDO and PDO_MYSQL extensions](https://www.php.net/manual/en/pdo.installation.php) installed and enabled
 * MySQL: 8.3+
 * Composer: 2.0+


## How to Run

1. Make sure your system meets the requirements.
2. Clone this repository to your local machine.
3. Navigate to the project directory in your terminal.
4. Copy configuration.sample.php to configuration.php. Open with text editor ./configuration.php and set up your mysql server and credentials (inside storages -> mysql -> config).
5. Install the composer packages
    ```
    composer Install
   ```
6. Before first use run the setup command:
    ```
   php bin/setup.php 
    ```
7. Run the test suite
   ```
   ./vendor/bin/phpunit
   ```
8. Run the program using the following command:

    ```
    php prime_multiplication_table.php [count] [options]
    ```

* Replace `[count]` with any desired  count of prime numbers to generate.
* Replace `[options]` with any desired command-line options. See below for available options.

## Command-line Options
- `--operation`: Allows for specifying a custom operation between prime numbers using one of the supported operators: `add`, `multiply`, `exponent` (default: `multiply`).
- `--output`: - Specifies the output method for the generated multiplication table. Available options at this point is only `console` (standard output).

Example 1:
```
php prime_multiplication_table.php 7
```

Example 2:
```
php prime_multiplication_table.php 7 --operation=multiply
```

Example 3:
```
php prime_multiplication_table.php 15 --operation=add --output=console
```

## Prime Number Generation Algorithm

This program implements a prime number generation algorithm known as "[Trial Division](https://en.wikipedia.org/wiki/Trial_division) for finding prime numbers" with Square Root Optimization. 
This optimization reduces the number of divisions needed when testing for primality by only checking odd numbers divisibility up to the square root of a number.

### Flow:
 1. Start with an initial candidate number (number = 3) and array with the first prime number ([2]).

 2. Increase the candidate number by 2: In that way we check only odd numbers reducing the number of checks required since the only even primary number is pre-defined.

 3. Check if the number is primary - to check primality:
    * Iterate through the list of prime numbers found so far.
    * For each prime number less than or equal to the square root of the candidate number, check if the candidate number is divisible by the prime number.
    * If the candidate number is divisible by any prime number up to its square root, it is composite and not prime. Otherwise, it is prime.
    * If the candidate number is prime, add it to the list of prime numbers.

 4. Repeat steps 2-4 until the desired number of prime numbers are found.

## Reasoning Behind the Algorithm

The "Trial Division with Square Root Optimization" significantly reduces the number of divisions needed when testing for primality, improving the efficiency of the prime number generation algorithm. 
This optimization is particularly useful for generating prime numbers efficiently, especially for larger values of count.

## Time Complexity
Coming soon...

