<?php
/**
 * Created by yhy
 * Date: 2018-04-18
 * Time: 14:13
 */

namespace structural\proxy;


class Proxy implements Subject
{
    protected $realSubject;
    public function __construct()
    {
        $this->realSubject instanceof RealSubject || $this->realSubject = new RealSubject();
    }

    public function sync()
    {
        // TODO: Implement sync() method.
        return $this->realSubject->sync();
    }

    public function getStatus()
    {
        // TODO: Implement getStatus() method.
        return $this->realSubject->getStatus();
    }
}