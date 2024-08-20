<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;

class AuthenticateWithToken
{
    public function handle( Request $request, Closure $next )
    {
        $token = $request -> bearerToken();

        if ( ! $token )
        {
            return response() -> json( 'Token not provided.',  401 );
        }

        $user = User::where( 'token', $token ) -> first();

        if ( ! $user )
        {
            return response() -> json( 'Invalid token.', 401 );
        }

        $request -> setUserResolver( function () use ( $user )
        {
            return $user;
        } );

        return $next( $request );
    }
}

