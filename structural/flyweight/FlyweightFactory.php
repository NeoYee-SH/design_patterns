<?php
/**
 * Created by PhpStorm.
 * User: yihuaiyuan
 * Date: 2018/5/24
 * Time: 下午10:05
 */

namespace structural\flyweight;


class FlyweightFactory
{
    private $_flyweights;

    public function __construct()
    {
        $this->_flyweights = array();
    }

    public function getFlyweight(int $uid)
    {
        if (isset($this->_flyweights[$uid]))
        {
            return $this->_flyweights[$uid];
        }
        else
        {
            return $this->_flyweights[$uid] = new ConcreteFlyweight($uid);
        }
    }
}