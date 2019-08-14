<?php
/**
 * Created by PhpStorm.
 * User: yihuaiyuan
 * Date: 2018-12-29
 * Time: 13:23
 */

namespace creational\builder;


class Order
{
    private $basic_info = [];
    private $goods_info = [];
    private $express_info = [];

    public function getBasicInfo():array
    {
        return $this->basic_info;
    }
    public function setBasicInfo(array $array):bool
    {
        $this->basic_info = $array;
        return true;
    }

    public function getGoodsInfo():array
    {
        return $this->goods_info;
    }
    public function setGoodsInfo(array $array):bool
    {
        $this->goods_info = $array;
        return true;
    }

    public function getExpressInfo():array
    {
        return $this->express_info;
    }
    public function setExpressInfo(array $array):bool
    {
        $this->express_info = $array;
        return true;
    }
}