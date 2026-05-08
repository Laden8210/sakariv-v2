<?php
/**
 * Database Connection (MySQL via XAMPP)
 * 
 * Loads credentials from .env via vlucas/phpdotenv.
 * Run `composer run migrate` to set up tables and seed data.
 */

require_once __DIR__ . '/../vendor/autoload.php';

// Load .env from project root
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->safeLoad();

function getDB(): PDO
{
    static $db = null;

    if ($db === null) {
        $host    = $_ENV['DB_HOST']      ?? '127.0.0.1';
        $port    = $_ENV['DB_PORT']      ?? '3306';
        $dbname  = $_ENV['DB_DATABASE']  ?? 'sakari_db';
        $user    = $_ENV['DB_USERNAME']  ?? 'root';
        $pass    = $_ENV['DB_PASSWORD']  ?? '';
        $charset = $_ENV['DB_CHARSET']   ?? 'utf8mb4';

        $dsn = "mysql:host={$host};port={$port};dbname={$dbname};charset={$charset}";

        $db = new PDO($dsn, $user, $pass);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }

    return $db;
}

/**
 * Helper: Get a setting value from the settings table
 */
function getSetting(string $key, string $default = ''): string
{
    static $cache = [];

    if (isset($cache[$key])) {
        return $cache[$key];
    }

    try {
        $db = getDB();
        $stmt = $db->prepare("SELECT setting_value FROM settings WHERE setting_key = ?");
        $stmt->execute([$key]);
        $value = $stmt->fetchColumn();
        $cache[$key] = $value !== false ? $value : $default;
    } catch (Exception $e) {
        $cache[$key] = $default;
    }

    return $cache[$key];
}

/**
 * Helper: Get all settings in a group
 */
function getSettingsByGroup(string $group): array
{
    try {
        $db = getDB();
        $stmt = $db->prepare("SELECT setting_key, setting_value FROM settings WHERE setting_group = ?");
        $stmt->execute([$group]);
        $results = [];
        while ($row = $stmt->fetch()) {
            $results[$row['setting_key']] = $row['setting_value'];
        }
        return $results;
    } catch (Exception $e) {
        return [];
    }
}
