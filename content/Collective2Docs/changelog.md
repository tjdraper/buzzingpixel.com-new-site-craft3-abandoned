# Collective for ExpressionEngine Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## 2.2.1 - 2017-11-04
### Fixed
- Fixed developer log deprecation warnings about adding js to head

## 2.2.0 - 2017-10-07
### Added
- Collective now uses the `core_boot` hook

## 2.1.0 - 2016-11-12
### Added
- Add EE 3 custom menu functionality
### Fixed
- Fixed an issue in more recent versions of EE where the sidebar might not show up

## 2.0.0 - 2015-10-24
### Changed
- Collective 2.0.0 is a major user facing overhaul for ExpressionEngine 3. It will not work with ExpressionEngine 2. However, the ExpressionEngine 2 version will remain in the downloadable zip file for a few versions so that if you need to use Collective with ExpressionEngine 2 you can do that. Collective 1.x will remain feature frozen even if Collective 2.x advances.
### Added
- Code compatibility with ExpressionEngine 3
- Collective 2.0.0 adopts the native look and feel of the ExpressionEngine 3 control panel
- Added the ability to sort simple grid field items via drag and drop
### Fixed
- Fixed a bug where submitting an update to groups might fail
- Fixed a bug where not all groups might appear in the sidebar
- Fixed several bugs with drag and drop sorting of various sortable items
- Fixed a bug where first visiting the Collective index page would not show the variables for the first group
- Fixed a bug in the update routine where the extension version might not get updated with the module version

## 1.1.2 - 2015-08-19
### Fixed
- Updated all forms to stop using deprecated EE methods for CSRF protection
- Updated the warning style when no license key has been entered to be friendlier

## 1.1.1 - 2015-07-23
### Fixed
- Fixed a bug where text fields could have script tags removed or characters converted in an undesired way

## 1.1.0 - 2015-07-09
### Added
- German language support
- Many thanks are in order to [Werner Gusset](http://www.octave2media.ch/web/portrait) for the German translation and testing!
### Fixed
- Fixed several areas where language items were hard-coded and needed to be in the language file

## 1.0.1 - 2015-06-30
### Added
- Resolved an database schema issue with new installs related to the Simple Grid fieldtype

## 1.0.0 - 2015-06-30
### Added
- This is the initial release of Collective featuring:
- End-user friendly global variables for your site
- Simple and intuitive user interface
- 5 types of variables: Text Input, Textarea, WYSIWYG, Checkbox, and Simple Grid
- Text Input and Textarea character limiting
- Variable groups with granular permissions
