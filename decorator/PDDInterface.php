<?php
/**
 * Created by yhy
 * Date: 2018-04-19
 * Time: 11:51
 */

namespace decorator;


abstract class PDDInterface implements SignInterface
{

    protected $service;
    public function __construct(SignInterface $service)
    {
        $this->service = $service;
    }

    public function getSign()
    {
        return $this->service->getSign();
    }
}