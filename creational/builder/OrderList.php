<?php
/**
 * Created by PhpStorm.
 * User: yihuaiyuan
 * Date: 2018-12-29
 * Time: 14:00
 */

namespace creational\builder;


class OrderList extends OrderBuilder
{
    public function basicInfo(int $order_id):bool
    {
        $order['order_id'] = $order_id;
        $order['basic'] = 'basic';
        $this->order_service->setBasicInfo($order);
        return true;
    }

    public function goodsInfo(int $order_id):bool
    {
        return true;
    }

    public function expressInfo(int $order_id):bool
    {
        $order['order_id'] = $order_id;
        $order['express'] = 'express';
        $this->order_service->setExpressInfo($order);
        return true;
    }
}