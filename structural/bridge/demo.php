<?php

require '../../auto.php';

use structural\bridge\WaitPay;
use structural\bridge\TaoBao;
use structural\bridge\WaitSellerSend;
use structural\bridge\JingDong;

$tbWaitPay = new WaitPay(new TaoBao());
$res = $tbWaitPay->sync();
print_r($res);
echo PHP_EOL;
$jdWaitSend = new WaitSellerSend(new JingDong());
$res = $jdWaitSend->sync();
print_r($res);
exit;
