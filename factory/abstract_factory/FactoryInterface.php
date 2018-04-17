<?php
/**
 * Created by yhy
 * Date: 2018-04-08
 * Time: 13:12
 */

namespace factory\abstract_factory;

Interface FactoryInterface
{
    public function createOrder();//创建Order对象

    public function createGoods();//创建Goods对象
}