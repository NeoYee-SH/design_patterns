<?php
/**
 * Created by yhy
 * Date: 2018-04-08
 * Time: 13:08
 */

namespace factory\abstract_factory;

Interface OrderInterface
{
    public function sync();//订单同步

    public function getStatus();//查状态
}