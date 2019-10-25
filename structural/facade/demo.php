<?php


require "../../auto.php";

use structural\facade\Facade;

$orders = (new Facade())->getAllOrdersDetail(20);
if($orders && \is_array($orders))
{
    foreach ($orders as $order)
    {
        print_r(json_encode($order));
        echo PHP_EOL;
    }
}
else
{
    print_r('返回数据异常');
}
exit;
