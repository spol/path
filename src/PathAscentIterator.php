<?php

namespace Spol\Path;

class PathAscentIterator implements \Iterator
{
    private $path;
    private $cursor;

    public function __construct($path)
    {
        $this->path = explode(DIRECTORY_SEPARATOR, rtrim($path, DIRECTORY_SEPARATOR));
        $this->rewind();
    }

    public function current()
    {
        return $this->build_path();
    }
    public function key()
    {
        return (count($this->path) - 1) - $this->cursor;
    }
    public function next()
    {
        $this->cursor--;
    }

    public function rewind()
    {
        $this->cursor = count($this->path) - 1;
    }

    public function valid()
    {
        return isset($this->path[$this->cursor]);
    }

    private function build_path()
    {
        $path = implode(DIRECTORY_SEPARATOR, array_slice($this->path, 0, $this->cursor+1));
        return ($path === '') ? DIRECTORY_SEPARATOR : $path;
    }
}
