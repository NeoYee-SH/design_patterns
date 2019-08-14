<?php
/**
 * Created by yhy
 * Date: 2018-03-30
 * Time: 17:19
 */

namespace factory\simple_factory;


class PinDuoDuo implements OrderInterface
{
    public function sync():string
    {
        return 'PinDuoDuo sync !';
    }

    public function getStatus():string
    {
        return 'PinDuoDuo status !';
    }

    public function sendGoods():string
    {
        return 'PinDuoDuo sendGoods !';
    }
}