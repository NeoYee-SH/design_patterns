<?php
/**
 * Created by yhy
 * Date: 2018-04-17
 * Time: 11:12
 */

namespace adapter;


use factory\simple_factory\Jingdong;

class JingDongAdaptee extends Jingdong implements AdapterInterface
{
    public function editGoods()
    {
        // TODO: Implement editGoods() method.
        return 'JingDong editGoods !';
    }

    public function searchOrders()
    {
        // TODO: Implement searchOrders() method.
        return 'JingDong searchOrders !';
    }
}