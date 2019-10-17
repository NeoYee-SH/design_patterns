<?php
/**
 * User: yihuaiyuan@qutoutiao.net
 * Date: 2019-08-14
 */

namespace strategy;


interface StrategyInterface
{
    public function query(string $waybillNo):string ;

    public function print(string $waybillNo):string ;
}