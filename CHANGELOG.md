# Changelog

## [Unreleased]

### Added

- Filesystem Adapter for integrating with Cloudflare R2 service

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


[Unreleased]: https://github.com/packettide/ee-cloud-files/compare/1.0.2...HEAD

[1.0.2]: https://github.com/packettide/ee-cloud-files/compare/1.0.1...1.0.2

[1.0.1]: https://github.com/packettide/ee-cloud-files/compare/1.0.0...1.0.1

[1.0.0]: https://github.com/packettide/ee-cloud-files/releases/tag/1.0.0
