<?php

declare(strict_types=1);

namespace App\Validator;

use City;
use ValueError;

class CityValidator
{

    // problem 3. jelikoz mam na starost pouze 6 mest nema duvod rozjizdet db nebo jakoukoli cache
    //. z toho duvodu muzu akorat testovat oproti enumu protoze je to nejrycheljsi mozne reseni
    public function __construct(public readonly string $city)
    {
    }

    public function isCityValid(): bool
    {
        if (!$this->isCityPartOfEnum()) {
            return false;
        }

        return true;
    }

    public function isCityPartOfEnum(): bool
    {
        try {
            City::from(strtolower($this->city));
            return true;
        } catch
        (ValueError $e) {
            return false;
        }
    }
}