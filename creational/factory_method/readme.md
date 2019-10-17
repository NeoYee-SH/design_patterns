#### 工厂方法模式
属于类创建模式， 通常说的工厂模式就是指工厂方法模式。 在工厂方法模式中， 工厂父类负责定义创建产品对象的公共接口， 工厂子类则负责生产具体的 产品对象，这样做的目的是将产品类的实例化操作延迟到工厂子类中完成。

是对简单工厂模式的升级，解决了简单工厂模式中， 因为新增产品类导致的要对工厂类进行修改的问题， 当不确定有多少个具体产品时， 可以用工厂方法模式， 针对上面电商订单的问题，当我们新增一个电商平台，比如说youzan，相对于修改工厂类 OrderFactory ，  将产品类的创建交给具体的工厂子类显然更加稳定， 以后继续新增产品， 只需要新建一个产品类和一个工厂类即可， 不需要等原来的结构：
![image](https://i.loli.net/2018/12/28/5c25e6c0247f0.jpg)


```php
interface IOrder
{
    public function sign():string ;
    public function createOrder(array $array):array ;
    public function updateOrder(array $array):bool ;
    public function deleteOrder(array $array):bool ;
    public function formatData(array $array):array ;
}

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

class YouZanOrder implements IOrder
{
    private $key = 'yz_key';
    private $secret = 'yz_secret';

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
        isset($array['order_id']) && $data['yz_id'] = $array['order_id'];
        isset($array['order_status']) && $data['yz_status'] = $array['order_status'];

        return $data;
    }
}

```

```php
interface IFactory
{
    public function service():IOrder;
}

class PinDuoDuoFactory implements IFactory
{
    public function service(): IOrder
    {
        return new PinDuoDuoOrder();
    }
}

class YouZanFactory implements IFactory
{
    public function service(): IOrder
    {
        return new YouZanOrder();
    }
}

$data['order_id'] = '1';
$data['order_status'] = '已发货';
$brand = 'yz';

$service = (new YouZanFactory())->service();
$ret1 = $service->createOrder($data);
print_r($ret1);
```