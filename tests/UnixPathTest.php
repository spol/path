<?php

namespace Spol\Path\Tests;

use Spol\Path\UnixPath;

class UnixPathTest extends \PHPUnit_Framework_TestCase
{
    public function testAbsolute()
    {
        $UnixPath = new UnixPath;
        $this->assertFalse($UnixPath->isAbsolute('foo/bar'));
        $this->assertTrue($UnixPath->isAbsolute('/foo/bar'));
        $this->assertFalse($UnixPath->isAbsolute(''));
        $this->assertTrue($UnixPath->isAbsolute('/'));
    }

    public function testExtension()
    {
        $UnixPath = new UnixPath;
        $this->assertEquals('.php', $UnixPath->extension('foo/bar/baz/info.php'));
        $this->assertEquals('.php', $UnixPath->extension('foo/bar/baz/info.blade.php'));
        $this->assertEquals('', $UnixPath->extension('foo/bar/baz/.htaccess'));
        $this->assertEquals('', $UnixPath->extension('foo/bar/baz/'));
        $this->assertEquals('', $UnixPath->extension('foo/bar/baz'));
        $this->assertEquals('.', $UnixPath->extension('foo/bar/baz/dummy.'));
    }

    public function testResolve()
    {
        $UnixPath = new UnixPath;
        $this->assertEquals('/bar', $UnixPath->resolve('/foo', '/bar'));
        $this->assertEquals('/foo/bar', $UnixPath->resolve('/foo', 'bar'));
        $this->assertEquals('/foo/baz', $UnixPath->resolve('/foo/bar', '../baz'));
        $this->assertEquals('/foo/bar/baz', $UnixPath->resolve('/foo/bar', './baz'));
        $this->assertEquals('/foo', $UnixPath->resolve('/', '../foo'));
    }

    public function testNormalize()
    {
        $UnixPath = new UnixPath;
        $this->assertEquals('A/B', $UnixPath->normalize('A/B'));
        $this->assertEquals('A/B', $UnixPath->normalize('A//B'));
        $this->assertEquals('A/B', $UnixPath->normalize('A/B/'));
        $this->assertEquals('A/B', $UnixPath->normalize('A/./B'));
        $this->assertEquals('A/B', $UnixPath->normalize('A/foo/../B'));
        $this->assertEquals('../A/B', $UnixPath->normalize('../A/B'));
        $this->assertEquals('../../A/B', $UnixPath->normalize('../../A/B'));

        $this->assertEquals('/A/B', $UnixPath->normalize('/A/B'));
        $this->assertEquals('/A/B', $UnixPath->normalize('/A//B'));
        $this->assertEquals('/A/B', $UnixPath->normalize('/A/B/'));
        $this->assertEquals('/A/B', $UnixPath->normalize('/A/./B'));
        $this->assertEquals('/A/B', $UnixPath->normalize('/A/foo/../B'));
    }

    public function testNormalizeCase()
    {
        $UnixPath = new UnixPath;
        $this->assertEquals('A/B', $UnixPath->normalizeCase('A/B'));
        $this->assertEquals('a/B', $UnixPath->normalizeCase('a/B'));
        $this->assertEquals('A/b', $UnixPath->normalizeCase('A/b'));
        $this->assertEquals('a/b', $UnixPath->normalizeCase('a/b'));
    }

    public function testCommonParent()
    {
        $UnixPath = new UnixPath;
        $this->assertEquals('A/B', $UnixPath->commonParent('A/B/C/D', 'A/B/E/D'));
        $this->assertEquals('', $UnixPath->commonParent('F/B/C/D', 'A/B/E/D'));
        $this->assertEquals('A/B', $UnixPath->commonParent('./A/B/C/D', './A/B/E/D'));
        $this->assertEquals('/A/B', $UnixPath->commonParent('/A/B/C/D', '/A/B/E/D'));
        $this->assertEquals('/A/B/C/D', $UnixPath->commonParent('/A/B/C/D', '/A/B/E/../C/D'));
        $this->assertEquals('..', $UnixPath->commonParent('../A', '../../A'));
    }

    public function testGetDrive()
    {
        $UnixPath = new UnixPath;
        $this->assertEquals('', $UnixPath->getDrive('A/B/C'));
        $this->assertEquals('', $UnixPath->getDrive('/A/B/C'));
        $this->assertEquals('', $UnixPath->getDrive('C:/A/B/C'));
    }
}
