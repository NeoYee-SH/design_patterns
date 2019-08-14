<?php
/**
 * Created by yhy
 * Date: 2018-04-08
 * Time: 13:09
 */

namespace factory\abstract_factory;


class OrderTaoBao implements OrderInterface
{
    public function sync():string
    {
        return 'TaoBao sync !';
    }

    public function getStatus():string
    {
        return 'TaoBao status !';
    }
}