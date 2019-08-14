<?php
/**
 * Created by PhpStorm.
 * User: yihuaiyuan
 * Date: 2018-12-27
 * Time: 16:52
 */

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
