<?php

namespace App\Http\Requests;

use App\Models\City;
use Illuminate\Foundation\Http\FormRequest;

class CalculatePriceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'addresses' => 'required|array|min:2',
            'addresses.*.country' => 'required|string',
            'addresses.*.zip' => 'required|string',
            'addresses.*.city' => 'required|string'
        ];
    }

    public function messages(): array
    {
        return [
            'addresses.required' => 'The addresses field is required.',
            'addresses.array' => 'The addresses field must be an array.',
            'addresses.min' => 'At least two addresses are required.',
            'addresses.*.country.required' => 'The country field is required.',
            'addresses.*.zip.required' => 'The zip field is required.',
            'addresses.*.city.required' => 'The city field is required.',
            'addresses.invalid' => 'One or more addresses are invalid or do not exist in the database.'
        ];
    }

    protected function prepareForValidation(): void
    {
        $invalidAddresses = [];

        foreach( $this -> addresses as $address )
        {
            $city = City::where( [
                'country' => $address[ 'country' ] ?? null,
                'zipCode' => $address[ 'zip' ] ?? null,
                'name' => $address[ 'city' ] ?? null
            ] ) -> first();

            if( ! $city )
            {
                $invalidAddresses[] = $address;
            }
        }

        if( ! empty( $invalidAddresses ) )
        {
            $this -> merge( [ 'invalid_addresses' => true ] );
        }
    }

    public function withValidator( $validator ): void
    {
        $validator -> after( function( $validator )
        {
            if( $this -> invalid_addresses )
            {
                $validator -> errors() -> add( 'addresses', 'One or more addresses are invalid or do not exist in the database.' );
            }
        } );
    }
}
