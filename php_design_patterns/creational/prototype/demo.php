
<?php
/**
 * Created by PhpStorm.
 * User: yihuaiyuan
 * Date: 2018-12-29
 * Time: 15:56
 */

require '../../auto.php';

use creational\prototype\GoodsPrototype;

$book = new GoodsPrototype();
$book->setGoodsId(1);
$book->setGoodsName('book');


$clothes = $book->copy();
$clothes->setGoodsId(2);
$clothes->setGoodsName('clothes');


print_r($book);
print_r($clothes);