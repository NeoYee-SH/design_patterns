<?php
/**
 * Created by PhpStorm.
 * User: yihuaiyuan
 * Date: 2018-12-28
 * Time: 16:37
 */

require '../../auto.php';

use creational\factory_method\YouZanFactory;

$data['order_id'] = '1';
$data['order_status'] = '已发货';
$brand = 'yz';

$service = (new YouZanFactory())->service();
$ret1 = $service->createOrder($data);
print_r($ret1);

