<?php
/**
 * Created by yhy
 * Date: 2018-04-18
 * Time: 11:41
 */

namespace structural\bridge;


class WaitPay extends StatusInterface
{
    public function sync():string
    {
        // TODO: Implement sync() method.

        return $this->_platform->sync().' WaitPay orders';
    }

}