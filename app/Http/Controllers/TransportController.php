<?php

namespace App\Http\Controllers;

use App\Contracts\DistanceCalculatorInterface;
use App\Contracts\PriceCalculatorInterface;
use App\Http\Requests\CalculatePriceRequest;
use Illuminate\Http\JsonResponse;

class TransportController extends Controller
{
    protected DistanceCalculatorInterface $distanceCalculator;
    protected PriceCalculatorInterface $priceCalculator;

    /**
     * TransportController constructor.
     *
     * @param DistanceCalculatorInterface $distanceCalculator
     * @param PriceCalculatorInterface $priceCalculator
     */
    public function __construct( DistanceCalculatorInterface $distanceCalculator, PriceCalculatorInterface $priceCalculator )
    {
        $this -> distanceCalculator = $distanceCalculator;

        $this -> priceCalculator = $priceCalculator;
    }

    /**
     * Calculates transport prices based on the route details.
     *
     * @param CalculatePriceRequest $request
     *
     * @return JsonResponse
     */
    public function calculatePrices( CalculatePriceRequest $request ): JsonResponse
    {
        $validated = $request -> validated();

        $distance = $this -> distanceCalculator -> calculateDistance( $validated[ 'addresses' ] );

        $prices = $this -> priceCalculator -> calculatePrices( $distance );

        return response() -> json( $prices );
    }
}
