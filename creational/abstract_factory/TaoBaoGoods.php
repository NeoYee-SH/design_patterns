<?php
/**
 * Created by PhpStorm.
 * User: yihuaiyuan
 * Date: 2018-12-28
 * Time: 18:01
 */

namespace creational\abstract_factory;


class TaoBaoGoods implements IGoods
{

    public function addGoods(array $array): array
    {
        $array['type'] = 'tb_add';
        return $array;
    }
}