<?php

declare(strict_types=1);

namespace App\Entity;

class WeatherDto
{

    private readonly \DateTimeImmutable $date;
    private readonly float $max;
    private readonly float $min;

}