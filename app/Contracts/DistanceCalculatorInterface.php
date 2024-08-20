<?php

namespace App\Contracts;

interface DistanceCalculatorInterface
{
    public function calculateDistance( array $addresses ): int;
}
