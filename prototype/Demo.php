<?php


function autoload($class)
{
    require dirname($_SERVER['SCRIPT_FILENAME']) . '//..//' . str_replace('\\', '/', $class) . '.php';
}

spl_autoload_register('autoload');


$res = new \prototype\TaoBaoPrototype();
$res->setToken('ttttt');
$res->setParams(new class
{
    public $fields = 'tid,status';
});
$res1 = $res->copy();
print_r($res1);
print_r($res);
exit;
