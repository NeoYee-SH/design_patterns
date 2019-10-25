<?php

namespace behavioral\strategy;


class StoStrategy implements StrategyInterface
{

    public function query(string $waybillNo):string
    {
        return 'sto express :'. $waybillNo;
    }

    public function print(string $waybillNo): string
    {
        return 'sto print :' . $waybillNo;
    }
}