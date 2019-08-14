<?php
/**
 * Created by PhpStorm.
 * User: yihuaiyuan
 * Date: 2018-12-28
 * Time: 18:06
 */

namespace creational\abstract_factory;


class JingDong implements IFactory
{
    public function orderService(): IOrder
    {
        return new JingDongOrder();
    }

    public function goodsService(): IGoods
    {
        return new JingDongGoods();
    }
}