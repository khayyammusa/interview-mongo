<?php

namespace App\Services;

use App\Contracts\DistanceCalculatorInterface;
use Illuminate\Support\Facades\Http;

class DistanceCalculator implements DistanceCalculatorInterface
{
    private string $googleApiKey;

    public function __construct()
    {
        $this -> googleApiKey = env( 'GOOGLE_MAPS_API_KEY' );
    }

    public function calculateDistance( array $addresses ): int
    {
        $totalDistance = 0;

        for( $i = 0; $i < count( $addresses ) - 1; $i++ )
        {
            $origin = "{$addresses[$i]['city']},{$addresses[$i]['zip']},{$addresses[$i]['country']}";

            $destination = "{$addresses[$i + 1]['city']},{$addresses[$i + 1]['zip']},{$addresses[$i + 1]['country']}";

            $response = Http::get( "https://maps.googleapis.com/maps/api/directions/json", [
                'origin' => $origin,
                'destination' => $destination,
                'key' => $this -> googleApiKey
            ] );

            $data = $response -> json();

            if( isset( $data[ 'routes' ][ 0 ][ 'legs' ][ 0 ][ 'distance' ][ 'value' ] ) )
            {
                $totalDistance += intval( $data[ 'routes' ][ 0 ][ 'legs' ][ 0 ][ 'distance' ][ 'value' ] / 1000 );
            }
        }

        return $totalDistance;
    }
}
