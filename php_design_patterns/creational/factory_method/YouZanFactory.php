<?php
/**
 * Created by PhpStorm.
 * User: yihuaiyuan
 * Date: 2018-12-28
 * Time: 16:36
 */

namespace creational\factory_method;


class YouZanFactory implements IFactory
{
    public function service(): IOrder
    {
        return new YouZanOrder();
    }
}