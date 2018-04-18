<?php


function autoload($class)
{
    require dirname($_SERVER['SCRIPT_FILENAME']) . '//..//' . str_replace('\\', '/', $class) . '.php';
}

spl_autoload_register('autoload');

$obj = new \proxy\Proxy();
$res = $obj->getStatus();
print_r($res);
echo '|';
$res = $obj->sendGoods();//会报错,
print_r($res);
exit;
