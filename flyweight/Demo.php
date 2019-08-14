<?php


function autoload($class)
{
    require dirname($_SERVER['SCRIPT_FILENAME']) . '//..//' . str_replace('\\', '/', $class) . '.php';
}

spl_autoload_register('autoload');

$obj = new \flyweight\FlyweightFactory();
//用户10共享的对象
$res = $obj->getFlyweight(10)->getUserInfo();
print_r($res);
echo '|';
//用户20共享的对象
$res = $obj->getFlyweight(20)->getUserInfo();
print_r($res);
echo PHP_EOL;
//用户10非共享的对象
$obj = new \flyweight\UnsharedConcreteFlyweight(10);
$res= $obj->getUserInfo();
print_r($res);
exit;
