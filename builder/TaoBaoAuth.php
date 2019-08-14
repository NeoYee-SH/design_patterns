<?php
/**
 * Created by yhy
 * Date: 2018-04-08
 * Time: 14:45
 */

namespace builder;


class TaoBaoAuth extends Builder
{
    public function setToken(string $token):bool
    {
        $this->_auth->token = $token;
        return true;
    }

    public function setAppKey():bool
    {
        $this->_auth->appKey = '0000';
        return true;
    }

    public function setAppSecret():bool
    {
        $this->_auth->appSecret = 'ooooooooooooooooooo';
        return true;
    }

    public function setMethod(string $method):bool
    {
        $this->_auth->method = $method;
        return true;
    }

    public function setAppParam(array $param):bool
    {
        $this->_auth->appParam = $param;
        return true;
    }

    public function getAuth():Auth
    {
        return $this->_auth;
    }
}