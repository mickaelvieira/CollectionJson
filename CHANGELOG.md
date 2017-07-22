# Change Log

All notable changes to this project will be documented in this file. This project adheres to [Semantic Versioning](http://semver.org/).

## [2.0.0](https://github.com/mickaelvieira/CollectionJson/compare/1.1.0...2.0.0) - 2017-07-22

### Added
- Add **partial** implementation of [PSR-13](http://www.php-fig.org/psr/psr-13/) for the `LINK` entity

### Changed
- Entities are now considered as `Value Objects` and are immutable

### Removed
- Drop support for **PHP5**

## [1.1.0](https://github.com/mickaelvieira/CollectionJson/compare/1.0.0...1.1.0) - 2016-05-16

### Added
- This ```CHANGELOG``` file
- [Coverall](http://coveralls.io/) configuration to track code coverage 

### Changed
- Optimize test suite's overall speed
- Disable PHP dynamic properties on entities
- Rename factory method of internal exceptions

## 1.0.0 - 2016-04-28

- Initial release
