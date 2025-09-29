# Changelog

## [0.2.0] - 2025-09-29

### Features
- Added root `index.php` bootstrap that routes all requests through `public/index.php`
- Introduced central `.htaccess` for routing and security (blocks non-public folders, sensitive files, and directory listings)
- Implemented custom `403.php` error page with logging support
- Integrated Composer autoload support
- Added optional Git initialization step in scaffolder script
- Added self-delete option for scaffolder after execution

### Refactors
- Consolidated access control logic into a single entry point instead of per-folder `.htaccess`

---

## [0.1.0] - 2025-09-29

### Initial Release
- Basic PHP project scaffolding structure
