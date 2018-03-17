<?php

namespace App\Models;

use Core\Model;
use PDO;

/**
 * Class User
 * @package App\Models
 */
class Customer extends Model
{
    public function __construct()
    {
        $this->setDB();
    }

    /**
     * Counts all the customers.
     *
     * @param array $timeSpan
     * @return array
     */
    public function getCount(array $timeSpan)
    {
        $sth = $this->getDB()->prepare(
            'SELECT COUNT(1) AS customerCount FROM app_customer WHERE reg_date >= STR_TO_DATE(:dateFrom, "%Y-%m-%d") AND reg_date <= STR_TO_DATE(:dateTo, "%Y-%m-%d")'
        );

        $sth->bindParam(':dateTo', $timeSpan['dateTo'], PDO::PARAM_STR);
        $sth->bindParam(':dateFrom', $timeSpan['dateFrom'], PDO::PARAM_STR);

        $sth->execute();

        return $sth->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Gets the customers count for the chart.
     *
     * @param array $timeSpan
     * @return array
     */
    public function getCustomerOrderData(array $timeSpan)
    {
        $sth = $this->getDB()->prepare(
            'SELECT COUNT(1) AS customerCount, DATE_FORMAT(reg_date, "%Y-%m-%d") AS reg_date
                       FROM app_customer 
                       WHERE reg_date >= STR_TO_DATE(:dateFrom, "%Y-%m-%d") 
                       AND reg_date <= STR_TO_DATE(:dateTo, "%Y-%m-%d")
                       GROUP BY DATE_FORMAT(reg_date, "%Y-%m-%d")'
        );

        $sth->bindParam(':dateTo', $timeSpan['dateTo'], PDO::PARAM_STR);
        $sth->bindParam(':dateFrom', $timeSpan['dateFrom'], PDO::PARAM_STR);

        $sth->execute();

        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
}
