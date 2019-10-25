<?php
/**
 * Created by yhy
 * Date: 2018-04-19
 * Time: 13:17
 */

namespace structural\decorator;


class Goods extends PDDInterface
{
    public function sendGoods()
    {
        $sign = $this->getSign();
        return $sign . ' sendGoods!';
    }

}