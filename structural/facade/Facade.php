<?php
/**
 * Created by yhy
 * Date: 2018-04-23
 * Time: 11:46
 */

namespace structural\facade;


class Facade
{

    public function getAllOrdersDetail($uid)
    {
        $orderList = (new Orders())->getOrderList($uid);
        $orders = \is_array($orderList) ? current($orderList) : [];

        $goodsService = new Goods();
        $expressService = new Express();

        $data = [];
        if($orders && \is_array($orders))
        {
            foreach ($orders as $orderId)
            {
                $data[$orderId]['detail'] = $orderId;
                $data[$orderId]['goods'] = $goodsService->getGoodsList($orderId);
                $data[$orderId]['express'] = $expressService->getExpress($orderId);
                $data[$orderId]['brand'] = $expressService->getBrand($orderId);
            }
        }
        return $data;
    }
}