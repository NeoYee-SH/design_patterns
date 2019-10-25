<?php
/**
 * Created by yhy
 * Date: 2018-04-19
 * Time: 11:39
 */

namespace structural\decorator;


class SignOne implements SignInterface
{
    public $clientSecret = '666666';
    public $version = '1.0';

    private $mallId;
    public function setMallId($mallId)
    {
        $this->mallId = $mallId;
    }
    public function getMallId()
    {
        return $this->mallId;
    }

    private $secret;
    public function setSecret($secret)
    {
        $this->secret = $secret;
    }
    public function getSecret()
    {
        return $this->secret;
    }

    private $method;
    public function setMethod($method)
    {
        $this->method = $method;
    }
    public function getMethod()
    {
        return $this->method;
    }

    private $params;
    public function setParams($params)
    {
        $this->params = $params;
    }
    public function getParams()
    {
        return $this->params;
    }

    public function getSign()
    {
        // TODO: Implement getSign() method.
        $data = [];
        $data['mallId'] = $this->getMallId();
        $data['secret'] = $this->getSecret();
        $data['method'] = $this->getMethod();
        $data['params'] = $this->getParams();
        $data['version'] = $this->version;
        ksort($data);

        $stringToBeSigned = $this->clientSecret;
        foreach ($data as $k => $v)
        {
            $stringToBeSigned .= "$k$v";
        }
        $stringToBeSigned .= $this->clientSecret;
        return 'v1 sign';
//        return strtoupper(md5($stringToBeSigned));
    }
}