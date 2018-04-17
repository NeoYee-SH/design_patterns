<?php
/**
 * Created by yhy
 * Date: 2018-04-17
 * Time: 11:39
 */

namespace adapter;


use factory\simple_factory\TaoBao;

class TaoBaoAdaptee implements AdapterInterface
{
    public $adapt;
    public function __construct()
    {
        $this->adapt = new TaoBao();
    }

    public function sync()
    {
        return $this->adapt->sync();
    }
    public function getStatus()
    {
        return $this->adapt->sendGoods();
    }
    public function sendGoods()
    {
        return $this->adapt->sendGoods();
    }
    public function editGoods()
    {
        return 'TaoBao editGoods !';
    }

    public function searchOrders()
    {
        return 'TaoBao searchOrders !';
    }

}