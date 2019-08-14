<?php
/**
 * Created by PhpStorm.
 * User: yihuaiyuan
 * Date: 2018-12-29
 * Time: 14:18
 */

require '../../auto.php';
use creational\builder\OrderDirector;
use creational\builder\OrderList;
use creational\builder\OrderDetail;

$order_id = 101;
$list = (new OrderDirector(new OrderList()))->orderInfo($order_id);
$detail = (new OrderDirector(new OrderDetail()))->orderInfo($order_id);

print_r($list);
print_r($detail);