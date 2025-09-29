<?php
/**
 * PHP Project Scaffolder with Composer + Git
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
    'bin/.gitkeep'           => "#!/usr/bin/env php\n<?php\n// CLI scripts go here\n",
    'config/config.php'      => "<?php\nreturn [\n    'app_name' => 'My PHP App',\n    'debug' => true,\n];\n",
    'docs/README.md'         => "# Documentation\n\nProject documentation lives here.\n",
    'public/index.php'       => "<?php\nrequire __DIR__ . '/../vendor/autoload.php';\n\nuse MyApp\\App;\n\n\$app = new App();\necho \$app->run();\n",
    'resources/placeholder.txt' => "Resources (images, translations, assets, etc.) go here.\n",
    'src/App.php'            => "<?php\nnamespace MyApp;\n\nclass App {\n    public function run(): string {\n        return \"Hello from src/App.php\";\n    }\n}\n",
    'tests/AppTest.php'      => "<?php\nuse PHPUnit\\Framework\\TestCase;\nuse MyApp\\App;\n\nclass AppTest extends TestCase {\n    public function testRun() {\n        \$app = new App();\n        \$this->assertSame('Hello from src/App.php', \$app->run());\n    }\n}\n",
    'CHANGELOG.md'           => "# Changelog\n\nAll notable changes will be documented here.\n",
    'CONTRIBUTING.md'        => "# Contributing\n\nGuidelines for contributing to this project.\n",
    'LICENSE'                => "MIT License\n\nCopyright (c) " . date('Y') . " Your Name\n",
    'README.md'              => "# My PHP App\n\nA barebones PHP project scaffold.\n",
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
    '.gitignore'             => <<<TXT
/vendor/
/node_modules/
/.env
/.phpunit.cache/
/.php-cs-fixer.cache
.DS_Store
.idea/
/*.log
TXT
];

echo "Creating project scaffold...\n\n";

foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
        echo "Created directory: $dir\n";
    }
}

foreach ($files as $file => $content) {
    if (!file_exists($file)) {
        file_put_contents($file, $content);
        echo "Created file: $file\n";
    }
}

echo "\nScaffold created successfully!\n";

// Ask about Git
echo "\nDo you want to initialize a Git repository? (y/n): ";
$handle = fopen("php://stdin", "r");
$line = trim(fgets($handle));

if (strtolower($line) === 'y') {
    if (!is_dir('.git')) {
        exec('git init 2>&1', $output, $ret);
        echo implode("\n", $output) . "\n";
        exec('git add .');
        exec('git commit -m "Initial project scaffold"');
        echo "Git repository initialized with first commit.\n";
    } else {
        echo "Git repo already exists, skipped initialization.\n";
    }
} else {
    echo "Skipping Git initialization.\n";
}

echo "\nNext steps:\n";
echo "  1. Run 'composer install'\n";
echo "  2. Start dev server: php -S localhost:8000 -t public\n";
echo "  3. Open http://localhost:8000 in your browser\n";

// Delete this script after running
$script = __FILE__;
if (file_exists($script)) {
    unlink($script);
    echo "\nScaffold script deleted itself.\n";
}
