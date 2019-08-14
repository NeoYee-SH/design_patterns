<?php
/**
 * Created by yhy
 * Date: 2018-03-30
 * Time: 17:20
 */

namespace factory\simple_factory;


class SampleFactory
{
    public static function platformService(string $platform)
    {
        switch ($platform)
        {
            case 'pdd':
                $service = new PinDuoDuo();
                break;
            case 'jd':
                $service = new Jingdong();
                break;
            case 'tb':
                $service = new TaoBao();
                break;
            default:
                return false;
        }

        return $service;
    }
}