<?php
/**
 * Created by yhy
 * Date: 2018-03-26
 * Time: 16:30
 */

namespace singleton;


class Singleton
{

    /**
     * @var
     */
    private static $instance;

    /**
     * @return Singleton
     */
    public static function getInstance():self
    {
        self::$instance instanceof self || self::$instance = new self();

        return self::$instance;
    }

    /**
     * @return string
     */
    public function test():string
    {
        return 'one';
    }

    /**
     * Singleton constructor.
     */
    private function __construct()
    {

    }

    /**
     * 防止被克隆
     */
    private function __clone()
    {
        // TODO: Implement __clone() method.
    }

    /**
     * 防止被反序列化
     */
    private function __wakeup()
    {
        // TODO: Implement __wakeup() method.
    }
}