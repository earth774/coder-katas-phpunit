<?php

namespace App;

class PrimeFactors
{

    public function generate($number)
    {
        $factors = [];

        // 1. Is the number divisible by 2
        // 2. If true, the divide by 2. If false, increase candidate and try again.
        // 3. Repeat.

        for ($divisor = 2; $number > 1; $divisor++) {
            for (; $number % $divisor == 0; $number /= $divisor) {
                $factors[] = $divisor;
            }
        }

        return $factors;
    }
}
