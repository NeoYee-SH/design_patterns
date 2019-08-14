<?php
/**
 * Created by PhpStorm.
 * User: yihuaiyuan
 * Date: 2018-12-29
 * Time: 14:12
 */

namespace creational\builder;


class OrderDirector
{
    public $builder;

    public function __construct(OrderBuilder $builder)
    {
        $this->builder = $builder;
    }
    public function orderInfo(int $order_id):Order
    {
        $this->builder->init($order_id);
        return $this->builder->orderInfo();
    }
}