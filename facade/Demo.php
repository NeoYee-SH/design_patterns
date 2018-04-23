<?php


function autoload($class)
{
    require dirname($_SERVER['SCRIPT_FILENAME']) . '//..//' . str_replace('\\', '/', $class) . '.php';
}

spl_autoload_register('autoload');

$orders = (new \facade\Facade())->getAllOrdersDetail(20);
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
