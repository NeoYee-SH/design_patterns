<?php
/**
 * User: yihuaiyuan@qutoutiao.net
 * Date: 2019-08-16
 */

namespace php_design_patterns\creational\singleton;


trait SingletonTrait
{
    private static $instance;

    private function __construct() {
    }

    private function __clone() {
    }

    private function __wakeup() {
    }

    public static function getInstance():self {
        self::$instance instanceof self || self::$instance = new self();
        return self::$instance;
    }
}