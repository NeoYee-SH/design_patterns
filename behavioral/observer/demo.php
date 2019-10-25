<?php


require "../../auto.php";

use behavioral\observer\WechatObserver;
use behavioral\observer\SinaObserver;
use behavioral\observer\User;
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