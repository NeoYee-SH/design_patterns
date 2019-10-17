<?php
/**
 * User: yihuaiyuan@qutoutiao.net
 * Date: 2019-08-14
 */

namespace strategy;


class ZtoStrategy implements StrategyInterface
{
    public function query(string $waybillNo):string
    {
        return 'zto express :'. $waybillNo;
    }

    public function print(string $waybillNo): string
    {
        return 'zto print :' . $waybillNo;
    }
}