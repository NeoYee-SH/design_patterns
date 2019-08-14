<?php
/**
 * Created by PhpStorm.
 * User: yihuaiyuan
 * Date: 2018-12-28
 * Time: 18:08
 */

namespace creational\abstract_factory;


class TaoBao implements IFactory
{
    public function orderService(): IOrder
    {
        return new TaoBaoOrder();
    }

    public function goodsService(): IGoods
    {
        return new TaoBaoGoods();
    }
}