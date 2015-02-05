<?php

namespace Spol\Path\Tests;

use Spol\Path\PathAscentIterator;

class PathAscentIteratorTest extends \PHPUnit_Framework_TestCase
{
    public function testForeach()
    {
        $iterator = new PathAscentIterator("/foo/bar/baz/qux");

        $expected = array(
            "/foo/bar/baz/qux",
            "/foo/bar/baz",
            "/foo/bar",
            "/foo",
            "/"
        );

        foreach ($iterator as $count => $path) {
            $this->assertEquals($expected[$count], $path);
        }

        $this->assertEquals($count+1, count($expected));
    }
}
