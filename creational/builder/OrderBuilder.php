<?php
/**
 * Created by PhpStorm.
 * User: yihuaiyuan
 * Date: 2018-12-29
 * Time: 13:50
 */

namespace creational\builder;


abstract class OrderBuilder
{

    public $order_service;
    public function __construct()
    {
        $this->order_service = new Order();

    }

    public function init(int $order_id):bool
    {
        $this->basicInfo($order_id);
        $this->goodsInfo($order_id);
        $this->expressInfo($order_id);
        return true;
    }

    abstract public function basicInfo(int $order_id):bool ;
    abstract public function goodsInfo(int $order_id):bool ;
    abstract public function expressInfo(int $order_id):bool ;

    public function orderInfo():Order
    {
        return $this->order_service;
    }
}