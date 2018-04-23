<?php
/**
 * Created by yhy
 * Date: 2018-04-23
 * Time: 11:43
 */

namespace facade;


class Goods
{
    public function getGoodsList($orderId)
    {
        return [
            $orderId.' goodsList' => ['1','2','3'],
        ];
    }

    public function getGoodsDetail($goodsId)
    {
        return $goodsId. 'detail';
    }

}