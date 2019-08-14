#### 单例模式

创建型设计模式， 保证一个类只有一个实例。

    私有静态属性
    私有构造函数
    公开静态方法
    
![image](https://i.loli.net/2018/12/27/5c249fbc44bf9.jpg)


```php
<?php
/**
 * Created by PhpStorm.
 * User: yihuaiyuan
 * Date: 2018-12-27
 * Time: 16:48
 */

namespace creational\singleton;


class Singleton
{

    private static $singleton;

    private function __construct()
    {
    }

    public static function getInstance():Singleton
    {
        self::$singleton instanceof Singleton || self::$singleton = new self();

        return self::$singleton;
    }
    
    public function test():string 
    {
        return __METHOD__;
    }
}
```

因为类 Singleton 的构造函数 __construct() 设置为私有，所以不能通过 new Singleton() 的方式实例化类， 但是提供一个公开的静态方法 getInstance , 在此方法中限制类验证如果类已经被实例化则返回此对象，避免多次实例化。

设想一个场景 ，对于一次客户端请求， 服务端会生成一个请求对象， 在整个请求处理过程中， 如果重复生成请求对象， 可能会造成资源的浪费等问题， 所以这里最好使用单例模式。

例如client是一个单例， 所以获取到的是同一个对象。
```php
class Client
{
    private static $clientInstance;

    private $request_id;

    private function __construct()
    {
        $this->request_id = rand(1000000, 9999999);
    }

    public static function getClient():Client
    {
        self::$clientInstance instanceof Client || self::$clientInstance = new self();
        return self::$clientInstance;
    }

    public function getReqId():int
    {
        return $this->request_id;
    }
}

class Server
{
    public function test1()
    {
        $request = Client::getClient();
        return 'test1:' . $request->getReqId();
    }

    public function test2()
    {
        $request = Client::getClient();
        return 'test2:' . $request->getReqId();
    }
}
$resp1 = (new Server())->test1();
$resp2 = (new Server())->test2();

print $resp1 . PHP_EOL . $resp2;

# output
# test1:6185850
# test2:6185850
```


