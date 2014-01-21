<?php

namespace Spol\Path;

class Path
{
    const OS = PHP_OS;

    public static function getImplementation()
    {
        if (strtoupper(substr(self::OS, 0, 3)) == "WIN") {
            return new WindowsPath();
        } else {
            return new UnixPath();
        }
    }

    public static function __callStatic($name, $arguments)
    {
        return call_user_func_array(array(self::getImplementation(), $name), $arguments);
    }
}
