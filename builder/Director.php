<?php
/**
 * Created by yhy
 * Date: 2018-04-08
 * Time: 14:48
 */

namespace builder;


class Director
{
    public function construct(Builder $_builder, array $param):Auth
    {


        $token = $param['token'] ?? '';
        $_builder->setToken($token);

        $method = $param['method'] ?? '';
        $_builder->setMethod($method);

        $appParam = $param['appParam'] ?? [];
        $_builder->setAppParam($appParam);

        $_builder->setAppKey();
        $_builder->setAppSecret();


        return $_builder->getAuth();
    }
}