#### 抽象工厂模式

属于对象创建型模式。 当工厂生产的具体产品是单一对象时， 可以采用简单工厂模式或者工厂方法模式； 当具体产品不是单一对象，而是属于多个不同的对象时，需要用到抽象工厂模式。

抽象工厂模式提供一个创建一系列相关或者相互依赖对象的接口，而无需指定他们具体的类。

还是对于上面提到的电商平台， 已有taobao和jingdong的订单对象， 现在业务扩展， 又涉及到对应平台的商品服务， 我们就需要构建产品对象。 但是对于一些业务场景，是需要得到一个更加完整的订单+商品对象的，于是可以这样实现：
  
![image](https://i.loli.net/2018/12/28/5c25fb0eac7e4.jpg)
```php

interface IOrder
{
    public function sign():string ;
    public function createOrder(array $array):array ;
    public function updateOrder(array $array):bool ;
    public function deleteOrder(array $array):bool ;
    public function formatData(array $array):array ;
}

class TaoBaoOrder implements IOrder
{
    private $key = 'tb_key';
    private $secret = 'tb_secret';

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
        isset($array['order_id']) && $data['tb_id'] = $array['order_id'];
        isset($array['order_status']) && $data['tb_status'] = $array['order_status'];

        return $data;
    }
}


class JingDongOrder implements IOrder
{
    private $key = 'jd_key';
    private $secret = 'jd_secret';

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
        isset($array['order_id']) && $data['jd_id'] = $array['order_id'];
        isset($array['order_status']) && $data['jd_status'] = $array['order_status'];

        return $data;
    }
}
```

```php
interface IGoods
{
    public function addGoods(array $array):array ;
}

class TaoBaoGoods implements IGoods
{

    public function addGoods(array $array): array
    {
        $array['type'] = 'tb_add';
        return $array;
    }
}

class JingDongGoods implements IGoods
{
    public function addGoods(array $array): array
    {
        $array['type'] = 'jd_add';
        return $array;
    }
}
```

```php

interface IFactory
{
    public function orderService():IOrder;
    public function goodsService():IGoods;
}

class TaoBao implements IFactory
{
    public function orderService(): IOrder
    {
        return new TaoBaoOrder();
    }

    public function goodsService(): IGoods
    {
        return new TaoBaoGoods();
    }
}

class JingDong implements IFactory
{
    public function orderService(): IOrder
    {
        return new JingDongOrder();
    }

    public function goodsService(): IGoods
    {
        return new JingDongGoods();
    }
}

$order['order_id'] = '1';
$order['order_status'] = '已发货';

$goods['goods_id'] = '2';

$ret['order'] = (new TaoBao())->orderService()->createOrder($order);
$ret['goods'] = (new TaoBao())->goodsService()->addGoods($goods);

print_r($ret);
```
