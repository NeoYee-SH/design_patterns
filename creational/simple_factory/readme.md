#### 简单工厂模式
属于类创建型设计模式， 工厂可以根据参数的不同返回不同类的实例，但是这些类的实例都具有共同的父类。 通常使用在存在多个已知的子类的创建。



比如有个电商项目， 跟主流电商平台taobao/jingdong/pinduoduo进行订单数据交互， 虽然都涉及到订单创建、订单修改、订单删除等几个动作， 但是不同平台的具体逻辑是不同的， 如果使用简单工厂模式， 则有如下代码：

![image](https://i.loli.net/2018/12/28/5c25993c008bb.jpg)


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
class OrderFactory
{

    public function service(string $brand):IOrder
    {
        switch ($brand)
        {
            case 'pdd':
                return new PinDuoDuoOrder();
                break;
            case 'jd':
                return new JingDongOrder();
                break;
            case 'tb':
                return new TaoBaoOrder();
                break;
            default:
                throw new \InvalidArgumentException('参数不正确', 101);
                break;
        }
    }
}


$data['order_id'] = '1';
$data['order_status'] = '已发货';
$brand = 'pdd';

$service = (new OrderFactory())->service($brand);
$ret1 = $service->createOrder($data);
print_r($ret1);

```