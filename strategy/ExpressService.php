<?php
/**
 * User: yihuaiyuan@qutoutiao.net
 * Date: 2019-08-14
 */


namespace strategy;

class ExpressService
{
    private $strategy;
    public function __construct(StrategyInterface $strategy){
        $this->strategy = $strategy;
    }

    public function query(string $waybillNo):string {
        return $this->strategy->query($waybillNo);
    }

    public function print(string $waybillNo):string {
        return $this->strategy->query($waybillNo);
    }
}

