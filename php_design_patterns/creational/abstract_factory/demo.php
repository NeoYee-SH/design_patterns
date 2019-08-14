<?php
/**
 * Created by PhpStorm.
 * User: yihuaiyuan
 * Date: 2018-12-28
 * Time: 18:08
 */

require '../../auto.php';
use creational\abstract_factory\TaoBao;

$order['order_id'] = '1';
$order['order_status'] = '已发货';

$goods['goods_id'] = '2';

$ret['order'] = (new TaoBao())->orderService()->createOrder($order);
$ret['goods'] = (new TaoBao())->goodsService()->addGoods($goods);

print_r($ret);


