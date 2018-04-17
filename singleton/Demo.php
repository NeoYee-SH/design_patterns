<?php


function autoload($class)
{
    require dirname($_SERVER['SCRIPT_FILENAME']) . '//..//' . str_replace('\\', '/', $class) . '.php';
}

spl_autoload_register('autoload');


$res = \singleton\Singleton::getInstance()->test();
print_r($res);
exit;
