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


$res = \factory\simple_factory\SampleFactory::platformService('tb')->getStatus();
print_r($res);
exit;
