# Changelog

## [Unreleased]

## [1.1.0] - 2023-07-28

### Added

- Filesystem Adapter for integrating with Cloudflare R2 service
- Support for eager loading a set of paths using parallel requests to improve performance

### Fixed

- Update dependencies for PHP 8.2 Support

## [1.0.2] - 2023-07-10

### Fixed

- S3 Adapter `getMetadata()` to properly return data for folders.  This resolves an issue with syncing subfolders.

## [1.0.1] - 2022-09-01

### Fixed

- Autoloader collisions on scoped files

## [1.0.0] - 2022-09-01

### Added

- ExpressionEngine Filesystem adapters for AWS S3 and DigitalOcean Spaces

[Unreleased]: https://github.com/ExpressionEngine/cloud-files/compare/1.1.0...HEAD

[1.1.0]: https://github.com/ExpressionEngine/cloud-files/compare/1.0.2...1.1.0

[1.0.2]: https://github.com/ExpressionEngine/cloud-files/compare/1.0.1...1.0.2

[1.0.1]: https://github.com/ExpressionEngine/cloud-files/compare/1.0.0...1.0.1

[1.0.0]: https://github.com/ExpressionEngine/cloud-files/releases/tag/1.0.0
