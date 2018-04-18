<?php
/**
 * Created by yhy
 * Date: 2018-04-18
 * Time: 11:44
 */

namespace bridge;


class WaitSellerSend extends StatusInterface
{

    public function sync():string
    {
        // TODO: Implement sync() method.
        return $this->_platform->sync().' WaitSellerSend orders';
    }
}