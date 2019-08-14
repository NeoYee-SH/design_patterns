<?php


function autoload($class)
{
    require dirname($_SERVER['SCRIPT_FILENAME']) . '//..//' . str_replace('\\', '/', $class) . '.php';
}

spl_autoload_register('autoload');


$director = new \builder\Director();

$tbAuth = $director->construct(new \builder\TaoBaoAuth(), [
    'token' => 'oooooooo',
    'method' => 'test.method',
    'appParam' => [
        'fields' => 'status,tid',
    ],
]);


echo $tbAuth->getSign();

echo '|';

$jdAuth = $director->construct(new \builder\JingDongAuth(),[
    'token' => 'xxxxxxxx',
    'method' => 'method.test',
    'appParam' => [
        'fields' => 'status,tid',
    ],
]);
echo $jdAuth->getSign();
exit;
