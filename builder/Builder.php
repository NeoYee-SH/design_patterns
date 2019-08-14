<?php
/**
 * Created by yhy
 * Date: 2018-04-08
 * Time: 14:31
 */

namespace builder;


abstract class Builder
{
    protected $_auth;

    public function __construct()
    {
        $this->_auth = new Auth();
    }

    abstract public function setToken(string $token);
    abstract public function setAppKey();
    abstract public function setAppSecret();
    abstract public function setMethod(string $method);
    abstract public function setAppParam(array $param);
    abstract public function getAuth();

}