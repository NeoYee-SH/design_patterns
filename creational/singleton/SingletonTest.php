<?php
/**
 * Created by PhpStorm.
 * User: yihuaiyuan
 * Date: 2018-12-27
 * Time: 16:48
 */

namespace php_design_patterns\creational\singleton;
include_once "../../autoload.php";
use function
    php_design_patterns\dump,
    php_design_patterns\rand_str;

class SingletonTest
{
    use SingletonTrait;

    private $traceId;
    private function __construct() {
        $this->traceId = crc32(rand_str(64));
    }

    public function test() {
        return $this->traceId;
    }
}

$ret1 = SingletonTest::getInstance()->test();
$ret2 = SingletonTest::getInstance()->test();
dump($ret1, $ret2);