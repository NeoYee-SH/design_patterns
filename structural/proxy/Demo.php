<?php


require "../../auto.php";

use structural\proxy\Proxy;

$obj = new Proxy();
$res = $obj->getStatus();
print_r($res);
echo '|';
$res = $obj->sendGoods();//会报错,
print_r($res);
exit;
