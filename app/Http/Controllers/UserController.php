<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login( LoginRequest $request ): JsonResponse
    {
        $user = User::where( 'email', $request -> email ) -> first();

        if ( ! ( $user && Hash::check( $request -> password, $user -> password ) ) )
        {
            return response() -> json( 'Wrong credentials!', 400 );
        }

        $token = $user->generateApiToken();

        return response() -> json( $token );
    }


    public function logout( Request $request ): JsonResponse
    {
        $user = $request -> user();

        $user -> revokeApiToken();

        return response() -> json( 'User logged out' );
    }
}
