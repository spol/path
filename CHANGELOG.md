# Change Log
All notable changes to this project will be documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/).

## [0.1.3] - 2015-02-16
### Added
- Added Path::realpath to add support for expanding home folder refs when
  using realpath (e.g. ~/foo becomes /home/{user}/foo).

## [0.1.2] - 2015-02-05
### Fixed
- Stopped adding trailing slashes to paths.

### Added
- Path::parent method for getting a path's parent folder.
- Path::combine method to concatenate path segments.

## [0.1.1] - 2015-02-05
### Fixed
- Improved Windows detection, thanks to Morrison Laju.

## 0.1.0 - 2014-01-19
### Added
- Everything - first version.

[0.1.3]: https://github.com/spol/path/compare/v0.1.2...v0.1.3
[0.1.2]: https://github.com/spol/path/compare/v0.1.1...v0.1.2
[0.1.1]: https://github.com/spol/path/compare/v0.1.0...v0.1.1
