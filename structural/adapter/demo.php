<?php
/**
 * Created by yhy
 * Date: 2018-04-17
 * Time: 11:58
 */


require '../../auto.php';

//use structural\adapter\TaoBaoAdaptee;
use structural\adapter\JingDongAdaptee;
$obj = new JingDongAdaptee();
$res = $obj->getStatus();
print_r($res);
$res = $obj->searchOrders();
print_r($res);
exit;