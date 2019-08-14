#### 原型模式
属于对象创建模式。 在实际项目中， 有时候我们需要创建多个类似的对象， 如果每次都通过new来创建，需要重复初始化的操作， 会带来较大的开销。 原型模式通过clone来生成类似的对象， 可以减少创建时的初始化等操作占用开销。

以电商平台场景来说，同一个订单可能会有多个商品， 多个商品对象虽然不同， 但都类似，这里就可以用原型模式来clone商品对象：

![image](https://i.loli.net/2018/12/29/5c27363d0b501.jpg)
```php
interface IGoods
{
    public function copy();
}


class GoodsPrototype implements IGoods
{

    private $goods_id;
    public function getGoodsId():int
    {
        return $this->goods_id;
    }
    public function setGoodsId(int $id):bool
    {
        $this->goods_id = $id;
        return true;
    }

    private $goods_name;
    public function getGoodsName():string
    {
        return $this->goods_name;
    }
    public function setGoodsName(string $name):bool
    {
        $this->goods_name = $name;
        return true;
    }

    private $model;
    public function getGoodsModel():GoodsModel
    {
        return $this->model;
    }
    public function setGoodsModel(GoodsModel $model):bool
    {
        $this->model = $model;
        return true;
    }

    public function copy()
    {
        return clone $this;
    }
}

``` 

```php
$book = new GoodsPrototype();
$book->setGoodsId(1);
$book->setGoodsName('book');


$clothes = $book->copy();
$clothes->setGoodsId(2);
$clothes->setGoodsName('clothes');


print_r($book);
print_r($clothes);
```