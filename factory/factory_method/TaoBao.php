<?php
/**
 * Created by yhy
 * Date: 2018-03-30
 * Time: 17:13
 */

namespace factory\factory_method;


class TaoBao implements OrderInterface
{
    public function sync():string
    {
        return 'TaoBao sync !';
    }

    public function getStatus():string
    {
        return 'TaoBao status !';
    }

    public function sendGoods():string
    {
        return 'TaoBao sendGoods !';
    }
}