<?php

namespace Spol\Path;

class UnixPath extends AbstractPath
{
    protected $DS = '/';

    public function isAbsolute($path)
    {
        if (empty($path)) {
            return false;
        }
        return $path[0] == $this->DS;
    }

    public function normalizeCase($path)
    {
        return $path;
    }

    public function getDrive($path)
    {
        return '';
    }
}
