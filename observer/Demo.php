<?php
/**
 * User: yihuaiyuan@qutoutiao.net
 * Date: 2019-08-14
 */

namespace observer;

function autoload($class)
{
    require dirname($_SERVER['SCRIPT_FILENAME']) . '//..//' . str_replace('\\', '/', $class) . '.php';
}

spl_autoload_register('observer\autoload');

$user = [
    'name' => 'ogenes',
    'age' => 18
];

$service = new User();
$service->register($user);
$wechat = new WechatObserver();
$sina = new SinaObserver();
$service->attach($wechat);
$service->attach($sina);;
$service->notify();