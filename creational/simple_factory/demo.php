<?php
/**
 * Created by PhpStorm.
 * User: yihuaiyuan
 * Date: 2018-12-28
 * Time: 10:37
 */

require '../../auto.php';

use creational\simple_factory\OrderFactory;

$data['order_id'] = '1';
$data['order_status'] = '已发货';
$brand = 'pdd';

$service = (new OrderFactory())->service($brand);
$ret1 = $service->createOrder($data);
print_r($ret1);

