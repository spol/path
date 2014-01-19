<?php

namespace Spol\Path\Tests;

use Spol\Path\WindowsPath;

class WindowsPathTest extends \PHPUnit_Framework_TestCase
{
    public function testAbsolute()
    {
        $WindowsPath = new WindowsPath;
        $this->assertFalse($WindowsPath->isAbsolute('foo\\bar'));
        $this->assertTrue($WindowsPath->isAbsolute('c:\\foo\\bar'));
        $this->assertFalse($WindowsPath->isAbsolute(''));
        $this->assertTrue($WindowsPath->isAbsolute('c:'));
    }

    public function testExtension()
    {
        $WindowsPath = new WindowsPath;
        $this->assertEquals('.php', $WindowsPath->extension('foo\\bar\\baz\\info.php'));
        $this->assertEquals('.php', $WindowsPath->extension('foo\\bar\\baz\\info.blade.php'));
        $this->assertEquals('', $WindowsPath->extension('foo\\bar\\baz\\.htaccess'));
        $this->assertEquals('', $WindowsPath->extension('foo\\bar\\baz\\'));
        $this->assertEquals('', $WindowsPath->extension('foo\\bar\\baz'));
        $this->assertEquals('.', $WindowsPath->extension('foo\\bar\\baz\\dummy.'));
    }

    public function testResolve()
    {
        $WindowsPath = new WindowsPath;
        $this->assertEquals('c:\\bar', $WindowsPath->resolve('c:\\foo', 'c:\\bar'));
        $this->assertEquals('c:\\foo\\bar', $WindowsPath->resolve('c:\\foo', 'bar'));
        $this->assertEquals('c:\\foo\\baz', $WindowsPath->resolve('c:\\foo\\bar', '..\\baz'));
        $this->assertEquals('c:\\foo\\bar\\baz', $WindowsPath->resolve('c:\\foo\\bar', '.\\baz'));
        $this->assertEquals('c:\\foo', $WindowsPath->resolve('c:\\', '..\\foo'));
    }

    public function testNormalize()
    {
        $WindowsPath = new WindowsPath;
        $this->assertEquals('A\\B', $WindowsPath->normalize('A\\B'));
        $this->assertEquals('A\\B', $WindowsPath->normalize('A\\\\B'));
        $this->assertEquals('A\\B', $WindowsPath->normalize('A\\B\\'));
        $this->assertEquals('A\\B', $WindowsPath->normalize('A\\.\\B'));
        $this->assertEquals('A\\B', $WindowsPath->normalize('A\\foo\\..\\B'));

        $this->assertEquals('c:\\A\\B', $WindowsPath->normalize('c:\\A\\B'));
        $this->assertEquals('c:\\A\\B', $WindowsPath->normalize('c:\\A\\\\B'));
        $this->assertEquals('c:\\A\\B', $WindowsPath->normalize('c:\\A\\B\\'));
        $this->assertEquals('c:\\A\\B', $WindowsPath->normalize('c:\\A\\.\\B'));
        $this->assertEquals('c:\\A\\B', $WindowsPath->normalize('c:\\A\\foo\\..\\B'));

        $this->assertEquals('A\\B', $WindowsPath->normalize('A/B'));
        $this->assertEquals('A\\B', $WindowsPath->normalize('A//B'));
        $this->assertEquals('c:\\A\\B', $WindowsPath->normalize('c:/A/B/'));
        $this->assertEquals('c:\\A\\B', $WindowsPath->normalize('c:/A/./B'));
        $this->assertEquals('c:\\A\\B', $WindowsPath->normalize('c:/A/foo/../B'));
    }

    public function testNormalizeCase()
    {
        $WindowsPath = new WindowsPath;
        $this->assertEquals('a/b', $WindowsPath->normalizeCase('A/B'));
        $this->assertEquals('a/b', $WindowsPath->normalizeCase('a/B'));
        $this->assertEquals('a/b', $WindowsPath->normalizeCase('A/b'));
        $this->assertEquals('a/b', $WindowsPath->normalizeCase('a/b'));
    }

    public function testGetDrive()
    {
        $UnixPath = new WindowsPath;
        $this->assertEquals('', $UnixPath->getDrive('A/B/C'));
        $this->assertEquals('', $UnixPath->getDrive('/A/B/C'));
        $this->assertEquals('C:', $UnixPath->getDrive('C:/A/B/C'));
    }
}
