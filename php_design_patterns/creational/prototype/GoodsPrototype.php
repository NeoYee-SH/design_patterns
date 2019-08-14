<?php
/**
 * Created by PhpStorm.
 * User: yihuaiyuan
 * Date: 2018-12-29
 * Time: 15:52
 */

namespace creational\prototype;


class GoodsPrototype implements IGoods
{

    private $goods_id;
    public function getGoodsId():int
    {
        return $this->goods_id;
    }
    public function setGoodsId(int $id):bool
    {
        $this->goods_id = $id;
        return true;
    }

    private $goods_name;
    public function getGoodsName():string
    {
        return $this->goods_name;
    }
    public function setGoodsName(string $name):bool
    {
        $this->goods_name = $name;
        return true;
    }

    private $model;
    public function getGoodsModel():GoodsModel
    {
        return $this->model;
    }
    public function setGoodsModel(GoodsModel $model):bool
    {
        $this->model = $model;
        return true;
    }

    public function copy()
    {
        return clone $this;
    }
}