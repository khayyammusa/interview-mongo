<?php

use App\Http\Controllers\
{
    TransportController,
    UserController
};


Route::controller( UserController::class ) -> group( function()
{
    Route::post( 'login', 'login' ) -> name( 'login' );
} );

Route::middleware( 'auth.token' ) -> group( function()
{
    Route::controller( UserController::class ) -> group( function()
    {
        Route::post( 'logout', 'logout' );
    } );

    Route::prefix( 'transport' ) -> controller( TransportController::class ) -> group( function()
    {
        Route::post( 'calculate-prices', 'calculatePrices' );
    } );
} );
