<?php

namespace Core;

class Autoload
{

    public static function initialize(array $directories)
    {
        $path = '';
        foreach ($directories as $dir)
        {
            $path .= PATH_SEPARATOR . $dir;
        }
        set_include_path(get_include_path() . PATH_SEPARATOR . $path);
        spl_autoload_register('Core\\Autoload::autoload');
    }

    public static function autoload($classname)
    {
        $filename = ucwords(str_replace('\\', ' ', $classname));
        $filename = str_replace(' ', DS, $filename) . '.php';
        $filename = strtolower($filename{0}) . substr($filename, 1);
        require_once $filename;
    }

}
