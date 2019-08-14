<?php
/**
 * Created by PhpStorm.
 * User: yihuaiyuan
 * Date: 2018-12-28
 * Time: 16:34
 */

namespace creational\factory_method;


class PinDuoDuoFactory implements IFactory
{
    public function service(): IOrder
    {
        return new PinDuoDuoOrder();
    }
}