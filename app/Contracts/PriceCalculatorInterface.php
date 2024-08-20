<?php

namespace App\Contracts;

interface PriceCalculatorInterface
{
    public function calculatePrices( int $distance ): array;
}
