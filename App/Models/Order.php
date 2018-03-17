<?php

namespace App\Models;

use Core\Model;
use PDO;

/**
 * Class Order
 * @package App\Models
 */
class Order extends Model
{
    public function __construct()
    {
        $this->setDB();
    }

    /**
     * Counts all the orders
     *
     * @param array $timeSpan
     * @return array
     */
    public function getCount(array $timeSpan)
    {
        $sth = $this->getDB()->prepare(
            'SELECT COUNT(1) AS orderCount FROM app_order WHERE purchase_date >= STR_TO_DATE(:dateFrom, "%Y-%m-%d") AND purchase_date <= STR_TO_DATE(:dateTo, "%Y-%m-%d")'
        );

        $sth->bindParam(':dateTo', $timeSpan['dateTo'], PDO::PARAM_STR);
        $sth->bindParam(':dateFrom', $timeSpan['dateFrom'], PDO::PARAM_STR);

        $sth->execute();

        return $sth->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Gets the revenue summing up all the items' prices.
     *
     * @param array $timeSpan
     * @return array
     */
    public function getRevenue(array $timeSpan)
    {
        $sth = $this->getDB()->prepare(
            ' SELECT SUM(app_item.price) AS totalRevenue
                        FROM app_order_item_rel
                        INNER JOIN app_order ON(app_order.id = app_order_item_rel.order_id)
                        INNER JOIN app_item ON(app_item.id = app_order_item_rel.item_id)
                        WHERE app_order.purchase_date >= STR_TO_DATE(:dateFrom, "%Y-%m-%d")
                        AND app_order.purchase_date <= STR_TO_DATE(:dateTo, "%Y-%m-%d")'
        );

        $sth->bindParam(':dateTo', $timeSpan['dateTo'], PDO::PARAM_STR);
        $sth->bindParam(':dateFrom', $timeSpan['dateFrom'], PDO::PARAM_STR);

        $sth->execute();

        return $sth->fetch(PDO::FETCH_ASSOC);
    }

    public function getGraphOrderData(array $timeSpan)
    {
        $sth = $this->getDB()->prepare(
            ' SELECT SUM(app_item.price) AS totalRevenue, DATE_FORMAT(purchase_date, "%Y-%m-%d") AS purchase_date 
                        FROM app_order_item_rel
                        INNER JOIN app_order ON(app_order.id = app_order_item_rel.order_id)
                        INNER JOIN app_item ON(app_item.id = app_order_item_rel.item_id)
                        WHERE app_order.purchase_date >= STR_TO_DATE(:dateFrom, "%Y-%m-%d")
                        AND app_order.purchase_date <= STR_TO_DATE(:dateTo, "%Y-%m-%d")
                        GROUP BY DATE_FORMAT(app_order.purchase_date, "%Y-%m-%d")'
        );

        $sth->bindParam(':dateTo', $timeSpan['dateTo'], PDO::PARAM_STR);
        $sth->bindParam(':dateFrom', $timeSpan['dateFrom'], PDO::PARAM_STR);

        $sth->execute();

        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
}