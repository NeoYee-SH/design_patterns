<?php
/**
 * Created by PhpStorm.
 * User: yihuaiyuan
 * Date: 2018-12-28
 * Time: 10:19
 */

namespace creational\factory_method;


class PinDuoDuoOrder implements IOrder
{
    private $key = 'pdd_key';
    private $secret = 'pdd_secret';

    public function sign(): string
    {
        return md5($this->key . $this->secret . time());
    }

    public function createOrder(array $array): array
    {
        $data = $this->formatData($array);
        if($data)
        {
            $data['sign'] = $this->sign();
        }
        $data['opt'] = 'create';
        return $data;
    }

    public function updateOrder(array $array): bool
    {
        $data = $this->formatData($array);
        if($data)
        {
            $data['sign'] = $this->sign();
        }
        $data['opt'] = 'update';
        return (bool)$data;
    }

    public function deleteOrder(array $array): bool
    {
        $data = $this->formatData($array);
        if($data)
        {
            $data['sign'] = $this->sign();
        }
        $data['opt'] = 'delete';
        return (bool)$data;
    }

    public function formatData(array $array):array
    {
        $data = [];
        isset($array['order_id']) && $data['pdd_sn'] = $array['order_id'];
        isset($array['order_status']) && $data['pdd_status'] = $array['order_status'];

        return $data;
    }

}