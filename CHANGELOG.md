# Change Log for Regex Dependency component

All notable changes to this project will be documented in this file.
The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).

## [v1.0.0] - Unreleased

### Added
- Code quality tools: sonarcloud, phpcs, phpstan
- Collection class for loading and combinined multiple configurations
- Support different regex openings/closings

### Changed
- ConfigurationItemCollection interface object required by Container constructor, no simple array anymore
- Repository transferred to FreshAdvance organization 
- Vendor name changed to fresh-advance
- Namespace changed to FreshAdvence
- Travis is not used anymore. Github actions is used as ci

### Fixed
- Fix problematic slash cases
- Improve performance by removing tests of expression on runtime 

### Removed
- Container::getConfiguration
    - As configuration is now applied on container, and updates container state, there is no way (and actually no point) to get reusable configuration in a simple way anymore.

## [v0.3.0] -  2019-11-10

### Added

- Make component compliant to PSR-11

[v1.0.0]: https://github.com/FreshAdvance/regex-dependency/compare/v0.3.0...master
[v0.3.0]: https://github.com/FreshAdvance/regex-dependency/compare/b607c1091...v0.3.0