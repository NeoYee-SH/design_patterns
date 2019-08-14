<?php
/**
 * Created by yhy
 * Date: 2018-04-02
 * Time: 16:47
 */
namespace factory\factory_method;
class FactoryTaoBao implements FactoryInterface
{
    public function create()
    {
        // TODO: Implement create() method.
        return new TaoBao();
    }

}