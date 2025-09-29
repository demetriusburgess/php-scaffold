# PHP Project Scaffolder

A simple PHP project scaffolder that quickly sets up a structured PHP project with Composer autoload, clean routing, and optional Git integration. The scaffolded project is ready for development right out of the box.

## Features

- Root `index.php` bootstrap forwards all requests to `public/index.php`
- Central `.htaccess` blocks access to non-public folders and routes requests cleanly
- Custom `403.php` page to block access to non-public folders
- Composer PSR-4 autoload support for your `src/` folder
- Optional Git initialization and first commit
- Self-delete option after scaffolding to keep your workspace clean

## Folder Structure

```yaml
bin/          # CLI scripts  
config/       # Configuration files  
docs/         # Project documentation  
public/       # Public web-accessible files (entrypoint here)  
resources/    # Images, translations, and other assets  
src/          # PHP source files  
tests/        # PHPUnit tests  
CHANGELOG.md  # Changelog for project updates  
CONTRIBUTING.md  
LICENSE  
README.md  
composer.json  
```

## Installation

Clone this repository or download `scaffold.php` and run:

```bash
php scaffold.php
```

## The script will:
1. Create the standard project folders and files
2. Generate composer.json and Composer autoload
3. Optionally initialize a Git repository and make the first commit
4. Remove itself automatically after execution

## Usage
## After running the scaffolder:

1. Install Composer dependencies (if any):

```bash
composer install
```

2. Start a local development server:

```bash
php -S localhost:8000 -t public
```

3. Open http://localhost:8000 in your browser to see the scaffold in action.

## Versioning

This scaffolder uses semantic versioning
. Each release is tagged in Git for easy reference.

## Contributing

Please see CONTRIBUTING.md for guidelines on contributing to this project.

## License

MIT License — see LICENSEfor details.