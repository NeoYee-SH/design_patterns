<?php
/**
 * Created by PhpStorm.
 * User: yihuaiyuan
 * Date: 2018-12-28
 * Time: 17:57
 */

namespace creational\abstract_factory;


interface IOrder
{
    public function sign():string ;
    public function createOrder(array $array):array ;
    public function updateOrder(array $array):bool ;
    public function deleteOrder(array $array):bool ;
    public function formatData(array $array):array ;
}