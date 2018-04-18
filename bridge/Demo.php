<?php


function autoload($class)
{
    require dirname($_SERVER['SCRIPT_FILENAME']) . '//..//' . str_replace('\\', '/', $class) . '.php';
}

spl_autoload_register('autoload');

$tbWaitPay = new \bridge\WaitPay(new \bridge\TaoBao());
$res = $tbWaitPay->sync();
print_r($res);
echo '|';
$jdWaitSend = new \bridge\WaitSellerSend(new \bridge\JingDong());
$res = $jdWaitSend->sync();
print_r($res);
exit;
