<?php

namespace App;

class TaskEstimateService
{
    public static function calculateEstimate(string $estimateString)
    {
        $timeParts = explode(' ', $estimateString);
        $estimate = 0;

        foreach ($timeParts as $part) {
            if (preg_match('/(\d+)([a-zA-Z]+)/', $part, $matches)) {
                $number = (int)$matches[1];
                $unit = $matches[2];

                if (!$unit) {
                    continue;
                }

                $estimate += match ($unit) {
                    'd' => $number * 24,
                    'h' => $number,
                    'm' => $number > 0 ? $number / 60 : 0,
                    default => $estimate
                };
            }
        }

        return $estimate;
    }
}
