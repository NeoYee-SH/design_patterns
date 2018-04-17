<?php
/**
 * Created by yhy
 * Date: 2018-04-16
 * Time: 15:38
 */

namespace prototype;


class TaoBaoPrototype implements PrototypeInterface
{

    private $appId = '12345';

    public function getAppId()
    {
        return $this->appId;
    }

    private $appKey = '54321';
    public function getAppKey()
    {
        return $this->appKey;
    }

    private $appSecret = 'xxxxxxxxxxx';
    public function getAppSecret()
    {
        return $this->appSecret;
    }

    private $serviceUrl = 'taobao.com';
    public function getServiceUrl()
    {
        return $this->serviceUrl;
    }


    private $token = '';
    public function setToken(string $token)
    {
        $this->token = $token;
    }
    public function getToken()
    {
        return $this->token;
    }

    private $params = '';
    public function setParams($params)
    {
        $this->params = $params;
    }
    public function getParams()
    {
        return $this->params;
    }


    public function copy():TaoBaoPrototype
    {
        // TODO: Implement copy() method.
        return clone $this;
    }
}