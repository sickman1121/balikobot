<?php

declare(strict_types=1);

namespace App\Validator;

use City;
use ValueError;

class CityValidator
{

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