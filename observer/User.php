<?php
/**
 * User: yihuaiyuan@qutoutiao.net
 * Date: 2019-08-14
 */

namespace observer;


class User extends Subject
{
    public function register(array $user):bool {
        echo 'register user success',PHP_EOL;
        $this->user = $user;
        return true;
    }
}