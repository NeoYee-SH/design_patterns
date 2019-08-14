<?php
/**
 * Created by yhy
 * Date: 2018-04-08
 * Time: 13:16
 */

namespace factory\abstract_factory;


class TaoBaoFactory implements FactoryInterface
{

    public function createOrder():OrderTaoBao
    {
        return new OrderTaoBao();
    }

    public function createGoods():GoodsTaoBao
    {
        return new GoodsTaoBao();
    }
}