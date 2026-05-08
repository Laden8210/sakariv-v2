<?php
/**
 * Sakari Migration & Seeder Runner
 * 
 * Usage:
 *   composer run migrate          - Run migrations + seeders
 *   composer run migrate:fresh    - Drop all tables, re-run migrations + seeders
 *   composer run migrate:rollback - Roll back all migrations
 *   composer run seed             - Run seeders only
 */

require_once __DIR__ . '/../vendor/autoload.php';

// Load .env
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->safeLoad();

// ─── Config from .env ────────────────────────────────────────
$config = [
    'host'      => $_ENV['DB_HOST']      ?? '127.0.0.1',
    'port'      => $_ENV['DB_PORT']      ?? '3306',
    'database'  => $_ENV['DB_DATABASE']  ?? 'sakari_db',
    'username'  => $_ENV['DB_USERNAME']  ?? 'root',
    'password'  => $_ENV['DB_PASSWORD']  ?? '',
    'charset'   => $_ENV['DB_CHARSET']   ?? 'utf8mb4',
    'collation' => $_ENV['DB_COLLATION'] ?? 'utf8mb4_unicode_ci',
];

$command = $argv[1] ?? 'migrate';
$migrationsDir = __DIR__ . '/migrations';
$seedersDir    = __DIR__ . '/seeders';

// ─── Colors for CLI output ──────────────────────────────────
function info(string $msg): void    { echo "\033[36m$msg\033[0m\n"; }
function success(string $msg): void { echo "\033[32m$msg\033[0m\n"; }
function warn(string $msg): void    { echo "\033[33m$msg\033[0m\n"; }
function error(string $msg): void   { echo "\033[31m$msg\033[0m\n"; }

// ─── Database Connection ────────────────────────────────────
function connectDB(array $config, bool $withDatabase = true): PDO
{
    $dsn = "mysql:host={$config['host']};port={$config['port']};charset={$config['charset']}";
    if ($withDatabase) {
        $dsn .= ";dbname={$config['database']}";
    }

    $pdo = new PDO($dsn, $config['username'], $config['password']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
}

function ensureDatabase(array $config): void
{
    $pdo = connectDB($config, false);
    $dbName = $config['database'];
    $charset = $config['charset'];
    $collation = $config['collation'];
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET $charset COLLATE $collation");
    info("  📦 Database '$dbName' ready.");
}

function ensureMigrationsTable(PDO $db): void
{
    $db->exec("CREATE TABLE IF NOT EXISTS migrations (
        id INT AUTO_INCREMENT PRIMARY KEY,
        migration VARCHAR(255) NOT NULL UNIQUE,
        batch INT NOT NULL DEFAULT 1,
        ran_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
}

function getRanMigrations(PDO $db): array
{
    $stmt = $db->query("SELECT migration FROM migrations ORDER BY id ASC");
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

function getNextBatch(PDO $db): int
{
    return (int) $db->query("SELECT COALESCE(MAX(batch), 0) + 1 FROM migrations")->fetchColumn();
}

// ─── Commands ───────────────────────────────────────────────
function runMigrations(PDO $db, string $dir): int
{
    ensureMigrationsTable($db);
    $ran = getRanMigrations($db);
    $batch = getNextBatch($db);
    $files = glob($dir . '/*.php');
    sort($files);
    $count = 0;

    foreach ($files as $file) {
        $name = basename($file, '.php');
        if (in_array($name, $ran)) {
            continue;
        }

        $migration = require $file;
        info("  ⬆  Migrating: $name");
        $migration->up($db);

        $stmt = $db->prepare("INSERT INTO migrations (migration, batch) VALUES (?, ?)");
        $stmt->execute([$name, $batch]);
        success("  ✅ Migrated:  $name");
        $count++;
    }

    if ($count === 0) {
        warn("  ⚡ Nothing to migrate — all migrations have already run.");
    }

    return $count;
}

function rollbackMigrations(PDO $db, string $dir): void
{
    ensureMigrationsTable($db);
    $ran = getRanMigrations($db);
    $files = glob($dir . '/*.php');
    $fileMap = [];
    foreach ($files as $f) {
        $fileMap[basename($f, '.php')] = $f;
    }

    foreach (array_reverse($ran) as $name) {
        if (!isset($fileMap[$name])) {
            warn("  ⚠  Migration file not found: $name (skipping)");
            continue;
        }
        $migration = require $fileMap[$name];
        info("  ⬇  Rolling back: $name");
        $migration->down($db);
        $db->prepare("DELETE FROM migrations WHERE migration = ?")->execute([$name]);
        success("  ✅ Rolled back:  $name");
    }
}

function freshMigrations(PDO $db, array $config, string $migrationsDir, string $seedersDir): void
{
    warn("  🗑  Dropping database '{$config['database']}'...");
    $pdo = connectDB($config, false);
    $pdo->exec("DROP DATABASE IF EXISTS `{$config['database']}`");
    success("  ✅ Database dropped.");

    ensureDatabase($config);
    $db = connectDB($config);

    echo "\n";
    info("━━━ Running Migrations ━━━");
    runMigrations($db, $migrationsDir);

    echo "\n";
    info("━━━ Running Seeders ━━━");
    runSeeders($db, $seedersDir);
}

function runSeeders(PDO $db, string $dir): void
{
    $files = glob($dir . '/*.php');
    sort($files);

    if (empty($files)) {
        warn("  ⚡ No seeders found.");
        return;
    }

    foreach ($files as $file) {
        $name = basename($file, '.php');
        info("  🌱 Seeding: $name");
        $seeder = require $file;
        $seeder->run($db);
    }
}

// ─── Main ───────────────────────────────────────────────────
echo "\n";
echo "\033[1;35m┌──────────────────────────────────────┐\033[0m\n";
echo "\033[1;35m│     Sakari Database Manager v1.0      │\033[0m\n";
echo "\033[1;35m└──────────────────────────────────────┘\033[0m\n";
echo "\n";

try {
    switch ($command) {
        case 'migrate':
            ensureDatabase($config);
            $db = connectDB($config);
            info("━━━ Running Migrations ━━━");
            runMigrations($db, $migrationsDir);
            echo "\n";
            info("━━━ Running Seeders ━━━");
            runSeeders($db, $seedersDir);
            break;

        case 'fresh':
            $db = null;
            freshMigrations($db, $config, $migrationsDir, $seedersDir);
            break;

        case 'rollback':
            ensureDatabase($config);
            $db = connectDB($config);
            info("━━━ Rolling Back Migrations ━━━");
            rollbackMigrations($db, $migrationsDir);
            break;

        case 'seed':
            ensureDatabase($config);
            $db = connectDB($config);
            info("━━━ Running Seeders ━━━");
            runSeeders($db, $seedersDir);
            break;

        default:
            error("Unknown command: $command");
            echo "\nAvailable commands:\n";
            echo "  migrate   - Run pending migrations + seeders\n";
            echo "  fresh     - Drop DB, re-run all migrations + seeders\n";
            echo "  rollback  - Roll back all migrations\n";
            echo "  seed      - Run seeders only\n";
            exit(1);
    }

    echo "\n";
    success("✅ Done!\n");

} catch (PDOException $e) {
    echo "\n";
    error("❌ Database Error: " . $e->getMessage());
    echo "\n";
    warn("💡 Make sure to:");
    echo "   1. Start MySQL in XAMPP Control Panel\n";
    echo "   2. Set DB_PASSWORD in your .env file\n";
    echo "   3. Check DB_HOST and DB_PORT in .env\n\n";
    exit(1);
} catch (Exception $e) {
    echo "\n";
    error("❌ Error: " . $e->getMessage());
    exit(1);
}
