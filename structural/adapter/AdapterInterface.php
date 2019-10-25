<?php
/**
 * Created by yhy
 * Date: 2018-04-17
 * Time: 11:09
 */

namespace structural\adapter;


interface AdapterInterface
{

    public function sync();
    public function getStatus();
    public function sendGoods();
    public function searchOrders();
    public function editGoods();
}