<?php
/**
 * Created by yhy
 * Date: 2018-04-23
 * Time: 13:37
 */

namespace structural\facade;


class Orders
{

    public function getOrderList($uid)
    {
        return [
            $uid. 'orderList'=>[
                6,7,8
            ],
        ];
    }

}