<?php
/**
 * Created by yhy
 * Date: 2018-04-17
 * Time: 11:58
 */


function autoload($class)
{
    require dirname($_SERVER['SCRIPT_FILENAME']) . '//..//' . str_replace('\\', '/', $class) . '.php';
}

spl_autoload_register('autoload');

//$obj = new \adapter\JingDongAdaptee();
$obj = new \adapter\TaoBaoAdaptee();
$res = $obj->getStatus();
print_r($res);
$res = $obj->searchOrders();
print_r($res);
exit;