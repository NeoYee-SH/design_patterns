<?php
/**
 * Created by yhy
 * Date: 2018-04-18
 * Time: 11:41
 */

namespace bridge;


abstract class StatusInterface
{

    public $_platform;
    public function __construct(PlatformInterface $platform)
    {
        $this->_platform = $platform;
    }

    abstract public function sync();
}