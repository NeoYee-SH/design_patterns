<?php
/**
 * Created by yhy
 * Date: 2018-04-08
 * Time: 13:10
 */

namespace factory\abstract_factory;


class OrderJingDong implements OrderInterface
{
    public function sync():string
    {
        return 'JingDong sync !';
    }

    public function getStatus():string
    {
        return 'JingDong status !';
    }
}