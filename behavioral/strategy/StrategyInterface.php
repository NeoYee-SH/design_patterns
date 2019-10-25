<?php

namespace behavioral\strategy;


interface StrategyInterface
{
    public function query(string $waybillNo):string ;

    public function print(string $waybillNo):string ;
}