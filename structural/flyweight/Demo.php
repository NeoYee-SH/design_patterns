<?php


require "../../auto.php";

use structural\flyweight\FlyweightFactory;
use structural\flyweight\UnsharedConcreteFlyweight;
$obj = new FlyweightFactory();
//用户10共享的对象
$res = $obj->getFlyweight(10)->getUserInfo();
print_r($res);
echo '|';
//用户20共享的对象
$res = $obj->getFlyweight(20)->getUserInfo();
print_r($res);
echo PHP_EOL;
//用户10非共享的对象
$obj = new UnsharedConcreteFlyweight(10);
$res= $obj->getUserInfo();
print_r($res);
exit;
