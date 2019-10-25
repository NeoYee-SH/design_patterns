<?php
/**
 * Created by yhy
 * Date: 2018-04-18
 * Time: 14:11
 */

namespace structural\proxy;


class RealSubject implements Subject
{

    public $platform = '';

    public $debugKey = 'proxy.RealSubject';

    public function sync()
    {
        // TODO: Implement sync() method.
        return 'sync';
    }

    public function getStatus()
    {
        // TODO: Implement getStatus() method.
        return 'getStatus';
    }

    public function sendGoods()
    {
        return 'sendGoods';
    }
}