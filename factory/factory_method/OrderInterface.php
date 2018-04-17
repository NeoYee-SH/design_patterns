<?php
/**
 * Created by yhy
 * Date: 2018-03-30
 * Time: 17:08
 */

namespace factory\factory_method;

Interface OrderInterface
{
    public function sync();//订单同步

    public function getStatus();//查状态

    public function sendGoods();//发货
}