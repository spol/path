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
        return preg_match('{^([A-Z]:\\\\?)}i', $path) === 1;
    }

    public function normalize($path)
    {
        $path = $this->normalizeSeparators($path);
        list ($drive, $path) = $this->splitDrive($path);
        return $drive . parent::normalize($path);
    }

    public function normalizeSeparators($path)
    {
        return str_replace('/', '\\', $path);
    }

    public function normalizeCase($path)
    {
        return strtolower($path);
    }

    public function splitDrive($path)
    {
        $drive = $this->getDrive($path);

        if ($drive)
        {
            $path = substr($path, strlen($drive));
        }
        else
        {
            $drive = '';
        }

        return [$drive, $path];
    }

    public function getDrive($path)
    {
        $path = $this->normalizeSeparators($path);
        if (preg_match('{^([A-Z]:\\\\)}i', $path) === 1) {
            return substr($path, 0, 2);
        }
    }

    public function parent($path)
    {
        if ($this->isAbsolute($path))
        {
            $drive = $this->getDrive($path);
        }
        else {
            $drive = '';
        }

        $path = substr($path, strlen($drive));

        if ($path === '' || $path === '\\')
        {
            return null;
        }

        $parent = $this->normalize($path . '\\..');

        if ($parent === '' && $path[0] === '\\')
        {
            return $drive . '\\';
        }

        return $drive . $parent;
    }
}
