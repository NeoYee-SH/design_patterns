#### 生成器模式
属于对象创建模式。生成器模式将一个复杂对象的构建与它的表示分离， 使得同样的构建过程可以创建爱你不同的表示。

在生成器模式， 用户可以通过指定复杂对象的类型和内容来构建对象， 不需要知道对象内部构建细节。

还以上面提到的电商订单为例， 对于一个订单对象， 通常包括收件人、发件人、商品信息、物流信息等复杂属性， 可是用户并不是总需要所有这些属性的，可能在订单列表只需要收发件人和物流信息，详情里面则需要所有这些信息等， 这时可以使用生成器模式：

![image](https://i.loli.net/2018/12/29/5c271d5b148bf.jpg)
```php
class Order
{
    private $basic_info = [];
    private $goods_info = [];
    private $express_info = [];

    public function getBasicInfo():array
    {
        return $this->basic_info;
    }
    public function setBasicInfo(array $array):bool
    {
        $this->basic_info = $array;
        return true;
    }

    public function getGoodsInfo():array
    {
        return $this->goods_info;
    }
    public function setGoodsInfo(array $array):bool
    {
        $this->goods_info = $array;
        return true;
    }

    public function getExpressInfo():array
    {
        return $this->express_info;
    }
    public function setExpressInfo(array $array):bool
    {
        $this->express_info = $array;
        return true;
    }
}

```

```php
abstract class OrderBuilder
{

    public $order_service;
    public function __construct()
    {
        $this->order_service = new Order();

    }

    public function init(int $order_id):bool
    {
        $this->basicInfo($order_id);
        $this->goodsInfo($order_id);
        $this->expressInfo($order_id);
        return true;
    }

    abstract public function basicInfo(int $order_id):bool ;
    abstract public function goodsInfo(int $order_id):bool ;
    abstract public function expressInfo(int $order_id):bool ;

    public function orderInfo():Order
    {
        return $this->order_service;
    }
}

class OrderList extends OrderBuilder
{
    public function basicInfo(int $order_id):bool
    {
        $order['order_id'] = $order_id;
        $order['basic'] = 'basic';
        $this->order_service->setBasicInfo($order);
        return true;
    }

    public function goodsInfo(int $order_id):bool
    {
        return true;
    }

    public function expressInfo(int $order_id):bool
    {
        $order['order_id'] = $order_id;
        $order['express'] = 'express';
        $this->order_service->setExpressInfo($order);
        return true;
    }
}

class OrderDetail extends OrderBuilder
{
    public function basicInfo(int $order_id):bool
    {
        $order['order_id'] = $order_id;
        $order['basic'] = 'basic';
        $this->order_service->setBasicInfo($order);
        return true;
    }

    public function goodsInfo(int $order_id):bool
    {
        $order['order_id'] = $order_id;
        $order['goods'] = 'goods';
        $this->order_service->setGoodsInfo($order);
        return true;
    }

    public function expressInfo(int $order_id):bool
    {
        $order['order_id'] = $order_id;
        $order['express'] = 'express';
        $this->order_service->setExpressInfo($order);
        return true;
    }
}

```

```php
class OrderDirector
{
    public $builder;

    public function __construct(OrderBuilder $builder)
    {
        $this->builder = $builder;
    }
    public function orderInfo(int $order_id):Order
    {
        $this->builder->init($order_id);
        return $this->builder->orderInfo();
    }
}

$order_id = 101;
$list = (new OrderDirector(new OrderList()))->orderInfo($order_id);
$detail = (new OrderDirector(new OrderDetail()))->orderInfo($order_id);

print_r($list);
print_r($detail);
```