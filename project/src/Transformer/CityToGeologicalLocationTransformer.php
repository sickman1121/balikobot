<?php

namespace App\Transformer;

use App\Entity\Geolocation;

class CityToGeologicalLocationTransformer
{

    private const CITIES = [
        'praha' => [
            'latitude' => 12.12121,
            'longitude' => -12.12121,
        ],
        'pardubice' => [
            'latitude' => 12.12121,
            'longitude' => -12.12121,
        ],
        'brno' => [
            'latitude' => 12.12121,
            'longitude' => -12.12121,
        ],
        'ostrava' => [
            'latitude' => 12.12121,
            'longitude' => -12.12121,
        ],
        'plzen' => [
            'latitude' => 12.12121,
            'longitude' => -12.12121,
        ],
        'olomouc' => [
            'latitude' => 12.12121,
            'longitude' => -12.12121,
        ]
    ];

    public function __construct(private readonly string $city)
    {
    }


    public function transformCityToGeoLocation(): Geolocation
    {
        return new Geolocation(
            self::CITIES[$this->city]['latitude'],
            self::CITIES[$this->city]['longitude']
        );
    }

}