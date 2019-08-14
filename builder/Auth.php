<?php
/**
 * Created by yhy
 * Date: 2018-04-08
 * Time: 14:23
 */
namespace builder;

class Auth
{
    public $token = '';
    public $appKey = '';
    public $appSecret = '';
    public $method = '';
    public $appParam = [];
    protected $sysParam = [];

    public function getSign():string
    {
        $this->sysParam['token'] = $this->token;
        $this->sysParam['appKey'] = $this->appKey;
        $this->sysParam['method'] = $this->method;
        $this->sysParam['ts'] = time();
        $this->sysParam['param'] = json_encode($this->appParam);
        ksort($this->sysParam);
        $signStr = $this->appSecret;
        foreach ($this->sysParam as $k=>$v)
        {
            $signStr .= $k.$v;
        }
        $signStr .= $this->appSecret;
//        return md5($signStr);
        return $signStr;

    }
}