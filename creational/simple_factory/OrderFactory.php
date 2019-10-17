<?php
/**
 * Created by PhpStorm.
 * User: yihuaiyuan
 * Date: 2018-12-28
 * Time: 10:34
 */

namespace creational\simple_factory;


class OrderFactory
{

    public function service(string $brand):IOrder
    {
        switch ($brand)
        {
            case 'pdd':
                return new PinDuoDuoOrder();
                break;
            case 'jd':
                return new JingDongOrder();
                break;
            case 'tb':
                return new TaoBaoOrder();
                break;
            default:
                throw new \InvalidArgumentException('参数不正确', 101);
                break;
        }
    }
}