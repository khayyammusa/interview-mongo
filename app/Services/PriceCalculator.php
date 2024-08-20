<?php

namespace App\Services;

use App\Contracts\PriceCalculatorInterface;
use App\Models\VehicleType;

class PriceCalculator implements PriceCalculatorInterface
{
    /**
     * Calculate the transportation prices for different vehicle types based on distance.
     *
     * @param float $distance
     *
     * @return array
     */
    public function calculatePrices( int $distance ): array
    {
        $vehicleTypes = VehicleType::all();

        $prices = [];

        foreach( $vehicleTypes as $vehicleType )
        {
            $price = $distance * $vehicleType -> cost_km;

            if( $price < $vehicleType -> minimum )
            {
                $price = $vehicleType -> minimum;
            }

            $prices[] = [
                'vehicle_type' => $vehicleType -> number,
                'price' => $price
            ];
        }

        return $prices;
    }
}
