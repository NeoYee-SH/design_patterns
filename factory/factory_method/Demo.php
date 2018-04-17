<?php
/**
 * Created by yhy
 * Date: 2018-03-30
 * Time: 17:58
 */


function autoload($class)
{
    require dirname($_SERVER['SCRIPT_FILENAME']) . '//..//..//' . str_replace('\\', '/', $class) . '.php';
}

spl_autoload_register('autoload');


$orderService = (new \factory\factory_method\FactoryJingDong())->create();
echo $orderService->sync();

echo '|';

$orderService = (new \factory\factory_method\FactoryTaoBao())->create();
echo $orderService->sync();
exit;
