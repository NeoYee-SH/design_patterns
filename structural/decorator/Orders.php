<?php
/**
 * Created by yhy
 * Date: 2018-04-19
 * Time: 13:16
 */

namespace structural\decorator;


class Orders extends PDDInterface
{

    public function sync()
    {
        $sign = $this->getSign();
        return $sign . ' sync!';
    }

}