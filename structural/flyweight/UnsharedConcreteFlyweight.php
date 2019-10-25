<?php
/**
 * Created by PhpStorm.
 * User: yihuaiyuan
 * Date: 2018/5/24
 * Time: 下午10:04
 */

namespace structural\flyweight;


class UnsharedConcreteFlyweight extends Flyweight
{
    private $uid;
    public function __construct(int $uid)
    {
        $this->uid = $uid;
    }

    public function getUserInfo()
    {
        return $this->uid. 'express';
    }
}