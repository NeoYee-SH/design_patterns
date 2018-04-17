<?php
/**
 * Created by yhy
 * Date: 2018-04-08
 * Time: 13:17
 */

namespace factory\abstract_factory;


class JingDongFactory implements FactoryInterface
{
    public function createOrder():OrderJingDong
    {
        return new OrderJingDong();
    }

    public function createGoods():GoodsJingDong
    {
        return new GoodsJingDong();
    }
}