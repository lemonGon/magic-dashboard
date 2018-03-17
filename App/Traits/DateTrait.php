<?php

namespace App\Traits;

/**
 * Class DateTrait
 * @package App\Traits
 */
trait DateTrait
{

    /**
     * Returns 2 dates' time span in MySql format given days and end date.
     *
     * @param string $dateFrom
     * @param string $dateTo
     * @throws \Exception
     * @return array
     */
    public static function getDateSpan($dateFrom, $dateTo)
    {
        $dateFrom = \DateTime::createFromFormat('Y-m-d', $dateFrom);
        $dateTo = \DateTime::createFromFormat('Y-m-d', $dateTo);

        if (!($dateFrom && $dateTo)) {
            throw new \Exception('Date From and/or Date to ar badly formatted', 400);
        }

        if ($dateFrom > $dateTo) {
            throw new \Exception('Date To cannot be greater than Date From', 400);
        }


        return [
            'dateTo' => "{$dateTo->format('Y-m-d')} 23:59:59",
            'dateFrom' => "{$dateFrom->format('Y-m-d')} 00:00:01",
        ];
    }
}