<?php
/**
 * Created by PhpStorm.
 * User: yihuaiyuan
 * Date: 2018/5/24
 * Time: 下午9:55
 */

namespace flyweight;



class ConcreteFlyweight extends Flyweight
{

    private $uid;
    public function __construct(int $uid)
    {
        $this->uid = $uid;
    }

    public function getUserInfo()
    {
        return $this->uid. 'token';
    }
}