<?php
/**
 * Created by yhy
 * Date: 2018-04-18
 * Time: 14:10
 */

namespace structural\proxy;


interface Subject
{

    public function sync();

    public function getStatus();
}