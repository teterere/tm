<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidEstimateFormat implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $maxDays = 365; // Max 1 year
        $maxHours = 72; // Max 72 hours
        $maxMinutes = 240; // Max 240 minutes

        if (!preg_match_all('/(\d+)(d|h|m)/', $value, $matches, PREG_SET_ORDER)) {
            $fail('Nederīgs formāts');

            return;
        }

        foreach ($matches as $match) {
            $amount = (int) $match[1];
            $unit = $match[2];

            if (
                ($unit === 'd' && $amount > $maxDays) ||
                ($unit === 'h' && $amount > $maxHours) ||
                ($unit === 'm' && $amount > $maxMinutes)
            ) {
                $fail('Pārsniegts limits');

                return;
            }
        }
    }
}
