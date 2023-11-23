<?php

namespace App;

use Exception;

class StringCalculator
{
    /**
     * The maximum number allowed.
     */
    const MAX_NUMBER_ALLOWED = 1000;

    /**
     * The delimiter for the numbers.
     *
     * @var string
     */
    protected string $delimiter = ",|\n";

    /**
     * Add the provided set of numbers.
     *
     * @param  string  $numbers
     * @return int
     *
     * @throws \Exception
     */
    public function add(string $numbers)
    {
        $this->disallowNegatives($numbers = $this->parseString($numbers));

        return array_sum(
            $this->ignoreGreaterThan1000($numbers)
        );
    }

    /**
     * Parse the numbers string.
     *
     * @param  string  $numbers
     * @return array
     */
    protected function parseString(string $numbers): array
    {
        $customDelimiter = '\/\/(.)\n';

        if (preg_match("/{$customDelimiter}/", $numbers, $matches)) {
            $this->delimiter = $matches[1];

            $numbers = str_replace($matches[0], '', $numbers);
        }

        return preg_split("/{$this->delimiter}/", $numbers);
    }

    /**
     * Do not allow any negative numbers.
     *
     * @param  array  $numbers
     * @throws Exception
     */
    protected function disallowNegatives(array $numbers): void
    {
        foreach ($numbers as $number) {
            if ($number < 0) {
                throw new Exception('Negative numbers are disallowed.');
            }
        }
    }

    /**
     * Forget any number that is greater than 1,000.
     *
     * @param  array  $numbers
     * @return array
     */
    protected function ignoreGreaterThan1000(array $numbers): array
    {
        return array_filter(
            $numbers,
            fn ($number) => $number <= self::MAX_NUMBER_ALLOWED
        );
    }
}
