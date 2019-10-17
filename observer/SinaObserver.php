<?php
/**
 * User: yihuaiyuan@qutoutiao.net
 * Date: 2019-08-14
 */

namespace observer;


class SinaObserver implements Observer
{
    public function update(Subject $subject)
    {
        echo 'sina', PHP_EOL;
        var_dump($subject->user);
        $this->pushSth([]);
    }

    public function pushSth(array $data) {
        var_dump($data);
    }
}