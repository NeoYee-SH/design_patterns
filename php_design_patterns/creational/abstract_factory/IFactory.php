<?php
/**
 * Created by PhpStorm.
 * User: yihuaiyuan
 * Date: 2018-12-28
 * Time: 18:04
 */

namespace creational\abstract_factory;


interface IFactory
{
    public function orderService():IOrder;
    public function goodsService():IGoods;
}