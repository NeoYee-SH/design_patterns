<?php
/**
 * User: yihuaiyuan@qutoutiao.net
 * Date: 2019-08-14
 */

namespace strategy;
function autoload($class)
{
    require dirname($_SERVER['SCRIPT_FILENAME']) . '//..//' . str_replace('\\', '/', $class) . '.php';
}

spl_autoload_register('strategy\autoload');


$service = new StoStrategy();
//$service = new ZtoStrategy();

$waybillNo = '43875945054554';

$queryRet = (new ExpressService($service))->query($waybillNo);

print_r($queryRet);