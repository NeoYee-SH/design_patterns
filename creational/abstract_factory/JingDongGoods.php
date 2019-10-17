<?php
/**
 * Created by PhpStorm.
 * User: yihuaiyuan
 * Date: 2018-12-28
 * Time: 18:02
 */

namespace creational\abstract_factory;


class JingDongGoods implements IGoods
{
    public function addGoods(array $array): array
    {
        $array['type'] = 'jd_add';
        return $array;
    }
}