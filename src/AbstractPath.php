<?php

namespace Spol\Path;

abstract class AbstractPath
{
    abstract public function isAbsolute($path);

    public function normalize($path)
    {
        $pathSegments = $this->split($path);
        $normalizedSegments = array();

        foreach ($pathSegments as $index => $segment) {
            if ($segment == '' && $index > 0) {
                continue;
            }

            if ($segment === '.') {
                continue;
            } elseif ($segment === '..' && !(empty($normalizedSegments) || end($normalizedSegments) === '..')) {
                if (count($normalizedSegments) == 1 && $normalizedSegments[0] == '')
                {
                    continue;
                }
                array_pop($normalizedSegments);
            } else {
                array_push($normalizedSegments, $segment);
            }
        }

        return implode($this->DS, $normalizedSegments);
    }

    abstract public function normalizeCase($path);

    abstract public function normalizeSeparators($path);

    /* On windows, returns the drive letter of the path,
     * on other platforms it returns the empty string.
     */
    abstract public function getDrive($path);

    /**
     * resolves one path ($path) relative to another ($start).
     * If $path is absolute, it will just return $path.
     *
     * examples:
     *   resolve('/home/foo', '../bar') => /home/foo
     *   resolve('/home/foo', 'bar') => /home/foo/bar
     */
    public function resolve($start, $path)
    {
        if ($this->isAbsolute($path)) {
            return $path;
        } else {
            $startSegments = $this->split($start);
            $pathSegments = $this->split($path);

            foreach ($pathSegments as $segment) {
                if ($segment === '.') {
                    continue;
                } elseif ($segment === '..') {
                    array_pop($startSegments);
                } else {
                    array_push($startSegments, $segment);
                }
            }

            return implode($this->DS, $startSegments);
        }
    }

    public function combine($one, $two)
    {
        return $this->normalize($one . $this->DS . $two);
    }

    /**
     * Returns the closest ancestor common to both paths.
     * examples:
     *   commonParent('/var/log/apache', '/var/log/mysql') => '/var/log'
     */
    public function commonParent($path1, $path2)
    {
        $path1Segments = $this->split($this->normalize($path1));
        $path2Segments = $this->split($this->normalize($path2));
        $commonSegments = array();

        $shortestLength = min(count($path1Segments), count($path2Segments));
        for ($i = 0; $i < $shortestLength; $i++) {
            if ($this->normalizeCase($path1Segments[$i]) == $this->normalizeCase($path2Segments[$i])) {
                array_push($commonSegments, $path1Segments[$i]);
            } else {
                break;
            }
        }

        return implode($this->DS, $commonSegments);
    }

    public function extension($path)
    {
        $parts = $this->split($path);
        $file = array_pop($parts);
        if (empty($file)) {
            return '';
        }
        $dotIndex = strrpos($file, '.');

        if ($dotIndex === false || $dotIndex === 0) {
            return '';
        } else {
            return substr($file, $dotIndex);
        }
    }


    public function split($path)
    {
        return explode($this->DS, $path);
    }
}
