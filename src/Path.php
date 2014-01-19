<?php

namespace Spol\Path;

class Path
{
    const OS = PHP_OS;

    public static function getImplementation()
    {
        switch (self::OS)
        {
            case "WINNT":
                return new WindowsPath();
                break;
            default:
                return new UnixPath();
        }
    }

    public static function __callStatic($name, $arguments)
    {
        return call_user_func_array(array(self::getImplementation(), $name), $arguments);
    }
}
