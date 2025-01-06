<?php

namespace App\Entity;

use DateTimeImmutable;

class WheatherResponse
{
        private readonly float $temperature2mMax;
        private readonly float $temperature2mMin;
        private readonly string $city;
        private readonly DateTimeImmutable $date;
}