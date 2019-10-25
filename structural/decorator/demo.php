<?php


require "../../auto.php";

use structural\decorator\Orders;
use structural\decorator\SignOne;
use structural\decorator\SignTwo;
use structural\decorator\Goods;

$res = new Orders(new SignOne());
print_r($res->sync());
echo PHP_EOL;
$res = new Orders(new SignTwo());
print_r($res->sync());
echo PHP_EOL;
$res = new Goods(new SignOne());
print_r($res->sendGoods());
echo PHP_EOL;
$res = new Goods(new SignTwo());
print_r($res->sendGoods());
exit;
