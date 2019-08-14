<?php
/**
 * Created by yhy
 * Date: 2018-03-30
 * Time: 17:11
 */

namespace factory\simple_factory;


class Jingdong implements OrderInterface
{
    public function sync():string
    {
        return 'JingDong sync !';
    }

    public function getStatus():string
    {
        return 'JingDong status !';
    }

    public function sendGoods():string
    {
        return 'JingDong sendGoods !';
    }
}