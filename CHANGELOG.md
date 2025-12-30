# Changelog

All notable changes to `LightService` will be documented in this file.

Updates should follow the [Keep a CHANGELOG](http://keepachangelog.com/) principles.

## [2.0.0] - 2025-12-30

### Changed
- **BREAKING**: Minimum PHP version raised to 8.2
- Upgraded PHPUnit to version 12.1
- Upgraded PHP_CodeSniffer to version 4.0
- Code modernization and cleanup with PHP 8.2+ features

## [1.0.4] - 2019-03-27

### Changed
- Promise validation is now skipped if one of the actions called the `skipRemaining` method

## [1.0.3] - 2019-03-18

### Added
- Organizer class is no longer abstract

## [1.0.1] - 2019-03-01

### Added
- ContextHelper class and its tests added

## [1.0.0] - 2019-02-28

### Added
- Action, Organizer, PreProcessor and PostProcessor classes added
