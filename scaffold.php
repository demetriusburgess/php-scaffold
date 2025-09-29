<?php
/**
 * Full PHP Project Scaffolder
 *
 * This script sets up a complete PHP project with a root index.php bootstrap, 
 * a custom 403 page that blocks access to non-public folders, and a public/.htaccess 
 * file for clean routing. It also generates a Composer autoload configuration, 
 * optionally initializes a Git repository, and deletes itself once the setup is complete.
 *
 * Run: php scaffold.php
 */

$dirs = [
    'bin',
    'config',
    'docs',
    'public',
    'resources',
    'src',
    'tests'
];

$files = [
    // Helpers/docs
    'bin/.gitkeep'           => "#!/usr/bin/env php\n<?php\n// CLI scripts go here\n",
    'config/config.php'      => "<?php\nreturn [\n    'app_name' => 'My PHP App',\n    'debug' => true,\n];\n",
    'docs/README.md'         => "# Documentation\n\nProject documentation lives here.\n",
    'resources/placeholder.txt' => "Resources (images, translations, assets, etc.) go here.\n",
    'CHANGELOG.md'           => "# Changelog\n\nAll notable changes will be documented here.\n",
    'CONTRIBUTING.md'        => "# Contributing\n\nGuidelines for contributing to this project.\n",
    'LICENSE'                => "MIT License\n\nCopyright (c) " . date('Y') . " Your Name\n",
    'README.md'              => "# My PHP App\n\nA barebones PHP project scaffold.\n",

    // Root bootstrap
    'index.php'              => "<?php\nrequire __DIR__ . '/public/index.php';\n",

    // Root .htaccess
    '.htaccess'              => <<<HTROOT
    <IfModule mod_rewrite.c>
        RewriteEngine On

        # Allow only root (/) and index.php
        RewriteCond %{REQUEST_URI} !^/$
        RewriteCond %{REQUEST_URI} !^/index\.php$

        # Redirect all other requests to 403.php with HTTP 403
        RewriteRule ^.*$ /public/403.php [R=403,L]

        Options -Indexes
    </IfModule>

    # Block sensitive files
    <FilesMatch "\.(env|json|lock|gitignore|ini|log|sh|pem|bak|swp|sql)$">
        Order allow,deny
        Deny from all
    </FilesMatch>
    HTROOT
    ,

    // Public entrypoint
    'public/index.php'       => "<?php\nrequire __DIR__ . '/../vendor/autoload.php';\n\nuse MyApp\\App;\n\n\$app = new App();\necho \$app->run();\n",

    // Public .htaccess for clean URLs
    'public/.htaccess'       => <<<HTPUB
    <IfModule mod_rewrite.c>
        RewriteEngine On
        RewriteBase /

        # Serve existing files in public
        RewriteCond %{REQUEST_FILENAME} -f [OR]
        RewriteCond %{REQUEST_FILENAME} -d
        RewriteRule ^ - [L]

        # Otherwise forward to public/index.php
        RewriteRule ^ index.php [QSA,L]
    </IfModule>

    # Block sensitive files
    <FilesMatch "\.(env|json|lock|gitignore|ini|log|sh|pem|bak|swp|sql)$">
        <IfModule mod_authz_core.c>
            Require all denied
        </IfModule>
        <IfModule !mod_authz_core.c>
            Order allow,deny
            Deny from all
        </IfModule>
    </FilesMatch>

    Options -Indexes
    HTPUB
    ,

    // 403 page
    'public/403.php' => <<<HTML
    <?php http_response_code(403); ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>403 Forbidden</title>
        <style>
            body { font-family: Arial, sans-serif; background: #f4f4f4; text-align: center; padding: 50px; }
            h1 { font-size: 50px; color: #c00; }
            p { font-size: 20px; }
        </style>
    </head>
    <body>
        <h1>403 Forbidden</h1>
        <p>Access to this directory is not allowed.</p>
    </body>
    </html>
    HTML
    ,

    // Example App class
    'src/App.php'            => "<?php\nnamespace MyApp;\n\nclass App {\n    public function run(): string {\n        return \"Hello from src/App.php\";\n    }\n}\n",

    // Basic PHPUnit test
    'tests/AppTest.php'      => "<?php\nuse PHPUnit\\Framework\\TestCase;\nuse MyApp\\App;\n\nclass AppTest extends TestCase {\n    public function testRun() {\n        \$app = new App();\n        \$this->assertSame('Hello from src/App.php', \$app->run());\n    }\n}\n",

    // Composer.json
    'composer.json'          => json_encode([
        "name" => "yourname/my-php-app",
        "description" => "Barebones PHP project scaffold",
        "type" => "project",
        "autoload" => [
            "psr-4" => [
                "MyApp\\" => "src/"
            ]
        ],
        "require" => new stdClass()
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n",

    // .gitignore
    '.gitignore'             => <<<GITIGNORE
    /vendor/
    /node_modules/
    /.env
    /.phpunit.cache/
    /.php-cs-fixer.cache
    /.idea/
    /*.log
    .DS_Store
    Thumbs.db
    GITIGNORE
];

echo "Creating project scaffold...\n\n";

// Create folders
foreach ($dirs as $dir) {
    if (!is_dir($dir)) mkdir($dir, 0755, true);
    echo "Created directory: $dir\n";
}

// Create files
foreach ($files as $file => $content) {
    if (!file_exists($file)) file_put_contents($file, $content);
    echo "Created file: $file\n";
}

echo "\nScaffold created.\n";

// Composer autoload
if (file_exists('composer.json')) {
    echo "Running composer dump-autoload...\n";
    exec('composer dump-autoload 2>&1', $composerOutput, $composerReturn);
    echo implode("\n", $composerOutput) . "\n";
}

// Optional Git init
echo "\nInitialize Git repo? (y/n): ";
$handle = fopen("php://stdin", "r");
$line = trim(fgets($handle));
if (strtolower($line) === 'y') {
    if (!is_dir('.git')) {
        exec('git init 2>&1', $gitInitOut);
        echo implode("\n", $gitInitOut) . "\n";
        exec('git add .');
        exec('git commit -m "chore: initial commit"');
        echo "Git repo initialized.\n";
    } else {
        echo "Git repo already exists.\n";
    }
}

// Self-delete
$self = __FILE__;
if (@unlink($self)) echo "\nScaffolding script deleted itself.\n";
else echo "\nDelete " . basename($self) . " manually.\n";

echo "\nDone. Next steps:\n";
echo "  1. Run: composer install\n";
echo "  2. Start server: php -S localhost:8000 -t public\n";
echo "  3. Open: http://localhost:8000\n";
