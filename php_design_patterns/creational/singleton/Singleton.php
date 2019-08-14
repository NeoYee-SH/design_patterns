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