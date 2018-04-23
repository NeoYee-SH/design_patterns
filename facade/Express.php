<?php
/**
 * Created by yhy
 * Date: 2018-04-23
 * Time: 13:37
 */

namespace facade;


class Express
{

    public function getExpress($orderId)
    {
        return $orderId. ' express .';
    }

    public function getBrand($orderId)
    {
        return $orderId. ' brand .';
    }
}