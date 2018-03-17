<?php

namespace App\Controllers;

use App\Models\Customer;
use App\Models\Order;
use Core\Controller;
use App\Traits\OutputTrait;
use App\Traits\DateTrait;

/**
 * Class Report
 * @package App\Controllers
 */
class Report extends Controller
{
    use OutputTrait;
    use DateTrait;

    /**
     * Gets the users count.
     */
    public function getUserCountAction()
    {
        $customer = new Customer;

        echo OutputTrait::jsonOutput(
            $customer->getCount(
                DateTrait::getDateSpan($_POST['dateFrom'], $_POST['dateTo'])
            ),
            'Accepted'
        );
    }

    /**
     * Gets the orders' count.
     */
    public function getOrderCountAction()
    {
        $order = new Order;

        echo OutputTrait::jsonOutput(
            $order->getCount(
                DateTrait::getDateSpan($_POST['dateFrom'], $_POST['dateTo'])
            ),
            'Accepted'
        );
    }

    /**
     * Gets the orders' revenue.
     */
    public function getOrderRevenueAction()
    {
        $order = new Order;

        echo OutputTrait::jsonOutput(
            $order->getRevenue(
                DateTrait::getDateSpan($_POST['dateFrom'], $_POST['dateTo'])
            ),
        'Accepted'
        );
    }

    /**
     * Gets the charts' data.
     */
    public function getGraphData()
    {
        $order = new Order;
        $customer = new Customer;

        $dateRange = DateTrait::getDateSpan($_POST['dateFrom'], $_POST['dateTo']);

        echo OutputTrait::jsonOutput(
            [
                'order' => $order->getGraphOrderData($dateRange),
                'customer' => $customer->getCustomerOrderData($dateRange)
            ],
            'Accepted'
    );
    }
}
