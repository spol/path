<?php

namespace Spol\Path;

class WindowsPath extends AbstractPath
{
    protected $DS = '\\';

    public function isAbsolute($path)
    {
        if (empty($path)) {
            return false;
        }
        return preg_match('{^([A-Z]:|\\\\)}i', $path) === 1;
    }

    public function normalize($path)
    {
        $path = str_replace('/', '\\', $path);
        return parent::normalize($path);
    }

    public function normalizeCase($path)
    {
        return strtolower($path);
    }

    public function getDrive($path)
    {
        if (preg_match('{^([A-Z]:|\\\\)}i', $path) === 1) {
            return substr($path, 0, 2);
        }
    }
}
