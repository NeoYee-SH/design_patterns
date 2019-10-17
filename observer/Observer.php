<?php
/**
 * User: yihuaiyuan@qutoutiao.net
 * Date: 2019-08-14
 */

namespace observer;


interface Observer
{
    public function update(Subject $subject);
}