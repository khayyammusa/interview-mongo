<?php

namespace App\Models;

use Jenssegers\Mongodb\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;

    protected $connection = 'mongodb';
    protected $collection = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'token'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime'
    ];

    /**
     * Generate a new API token and save it in the token column.
     *
     * @return string
     */
    public function generateApiToken()
    {
        $this -> token = hash( 'sha256', Str::random( 60 ) );

        $this -> save();

        return $this -> token;
    }

    /**
     * Revoke the current API token.
     */
    public function revokeApiToken()
    {
        $this -> token = null;

        $this -> save();
    }

    /**
     * Verify if the provided token matches the stored one.
     *
     * @param string $token
     * @return bool
     */
    public function verifyApiToken( $token )
    {
        return $this -> token === $token;
    }
}
