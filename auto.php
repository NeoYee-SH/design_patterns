<?php
/**
 * Created by PhpStorm.
 * User: yihuaiyuan
 * Date: 2018-12-27
 * Time: 13:31
 */

class Auto
{
    public function init()
    {
        \spl_autoload_register(__NAMESPACE__ . '\\Auto::autoload');
        return;
    }

    public static function autoload(string $className):void
    {
        $file = ROOTPATH . str_replace('\\', '/', $className) . '.php';
        if(file_exists($file))
        {
            require $file;
        }
        else
        {
            throw new ErrorException('file not fount: '.$file, '101');
        }
        return;
    }
}
define('ROOTPATH', __DIR__ . '/');
(new Auto())->init();
