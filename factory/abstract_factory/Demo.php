<?php
/**
 * Created by yhy
 * Date: 2018-04-08
 * Time: 13:20
 */


function autoload($class)
{
    require dirname($_SERVER['SCRIPT_FILENAME']) . '//..//..//' . str_replace('\\', '/', $class) . '.php';
}

spl_autoload_register('autoload');


$tbOrder = (new \factory\abstract_factory\TaoBaoFactory())->createOrder();
echo $tbOrder->sync();

echo '|';

$jdGoods = (new \factory\abstract_factory\JingDongFactory())->createGoods();
echo $jdGoods->sendGoods();
exit;
