<?php

namespace Spol\Path\Tests;

use Spol\Path\Path;
use Spol\Path\UnixPath;
use Spol\Path\WindowsPath;

class PathTest extends \PHPUnit_Framework_TestCase
{
    public function testGetImplementation()
    {
        $nativePathClass = strtoupper(substr(PHP_OS, 0, 3)) === "WIN" ? "Spol\Path\WindowsPath" : "Spol\Path\UnixPath";
        $this->assertInstanceOf($nativePathClass, Path::getImplementation());

        runkit_constant_redefine("Spol\Path\Path::OS", "WINNT");
        $this->assertInstanceOf("Spol\Path\WindowsPath", Path::getImplementation());
        runkit_constant_redefine("Spol\Path\Path::OS", "Darwin");
        $this->assertInstanceOf("Spol\Path\UnixPath", Path::getImplementation());
    }

    public function testCallStatic()
    {
        $mocked_static = new \PHPUnit_Extensions_MockStaticMethod( '\Spol\Path\Path::getImplementation', $this );
        $implementationMock = $this->getMock('Spol\Path\UnixPath');

        $implementationMock
            ->expects($this->once())
            ->method('normalize')
            ->with('a/b/c');

        $mocked_static
            ->expects($this->once())
            ->will($this->returnValue($implementationMock));

        Path::normalize('a/b/c');
    }
}
