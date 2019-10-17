<?php
/**
 * User: yihuaiyuan@qutoutiao.net
 * Date: 2019-08-14
 */

namespace observer;


class WechatObserver implements Observer
{
    public function update(Subject $subject)
    {
        echo 'wechat', PHP_EOL;
        var_dump($subject->user);
        $this->doSth([]);
    }

    public function doSth(array $data) {
        var_dump($data);
    }
}