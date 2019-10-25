<?php


require "../../auto.php";

use behavioral\strategy\StoStrategy;
use behavioral\strategy\ZtoStrategy;
use behavioral\strategy\ExpressService;



$service = new StoStrategy();
//$service = new ZtoStrategy();

$waybillNo = '43875945054554';

$queryRet = (new ExpressService($service))->query($waybillNo);

print_r($queryRet);