<?php


function autoload($class)
{
    require dirname($_SERVER['SCRIPT_FILENAME']) . '//..//' . str_replace('\\', '/', $class) . '.php';
}

spl_autoload_register('autoload');


$res = new \decorator\Orders(new \decorator\SignOne());
print_r($res->sync());
echo PHP_EOL;
$res = new \decorator\Orders(new \decorator\SignTwo());
print_r($res->sync());
echo PHP_EOL;
$res = new \decorator\Goods(new \decorator\SignOne());
print_r($res->sendGoods());
echo PHP_EOL;
$res = new \decorator\Goods(new \decorator\SignTwo());
print_r($res->sendGoods());
exit;
