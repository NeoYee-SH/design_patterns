<?php
/**
 * Created by PhpStorm.
 * User: yihuaiyuan
 * Date: 2018-12-28
 * Time: 16:33
 */

namespace creational\factory_method;


interface IFactory
{
    public function service():IOrder;
}