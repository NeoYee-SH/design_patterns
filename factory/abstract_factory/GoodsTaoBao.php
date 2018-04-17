<?php
/**
 * Created by yhy
 * Date: 2018-04-08
 * Time: 13:11
 */

namespace factory\abstract_factory;


class GoodsTaoBao implements GoodsInterface
{
    public function sendGoods():string
    {
        return 'TaoBao sendGoods !';
    }
}