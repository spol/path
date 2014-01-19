# Path by [@spol](https://twitter.com/spol)

Path is a simple library for manipulating strings containing filesystem paths.

# Installation

Through composer:

```json
{
    "require": {
        "spol/path": "0.1.*"
    }
}
```

# Usage

There are two concrete implementations of the Spol\Path\AbstractPath class, Spol\Path\UnixPath and Spol\Path\WindowsPath.
Both provide the same interface, but handle directory separators and drive letters differently.

The `Spol\Path\Path` class provides a static facade to the appropriate class for the current system. Alternatively, either
class can be used directly, such as for working with paths for a different system.

```php
Path::normalize('/usr/local/../bin')    // '/usr/bin'
```

To Be Completed.
