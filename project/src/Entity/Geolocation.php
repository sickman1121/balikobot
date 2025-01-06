<?php

namespace App\Entity;

class Geolocation
{
    public function __construct(
        public float $latitude,
        public float $longitude
    )
    {
    }
}