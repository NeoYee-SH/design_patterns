<?php
/**
 * Created by yhy
 * Date: 2018-04-19
 * Time: 11:48
 */

namespace decorator;


class SignTwo implements SignInterface
{
    public $clientSecret = '666666';
    public $version = '2.0';
    public $clientId = '000000';

    private $accessToken;
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
    }
    public function getAccessToken()
    {
        return $this->accessToken;
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
        $data['access_token'] = $this->getAccessToken();
        $data['method'] = $this->getMethod();
        $data['params'] = $this->getParams();
        $data['version'] = $this->version;
        $data['client_id'] = $this->clientId;
        ksort($data);

        $stringToBeSigned = $this->clientSecret;
        foreach ($data as $k => $v)
        {
            $stringToBeSigned .= "$k$v";
        }
        $stringToBeSigned .= $this->clientSecret;
        return 'v2 sign';
//        return strtoupper(md5($stringToBeSigned));
    }
}