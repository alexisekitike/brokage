<?php
// -----------------------------------------------------------------------------
// LOAD .ENV
// -----------------------------------------------------------------------------

require_once __DIR__ . '/../vendor/autoload.php';

// Use safeLoad(): It will load the .env file if it exists, 
// and do nothing if it doesn't (perfect for production).
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad();

// -----------------------------------------------------------------------------
// DATABASE CONFIG FROM ENV
// -----------------------------------------------------------------------------

// $_ENV variables are populated by .env (locally) or by Render's dashboard (production)
$DB_SERVER   = $_ENV['DB_SERVER']   ?? '127.0.0.1';
$DB_USERNAME = $_ENV['DB_USERNAME'] ?? 'root';
$DB_PASSWORD = $_ENV['DB_PASSWORD'] ?? '';
$DB_NAME     = $_ENV['DB_NAME']     ?? 'test';
$DB_PORT     = (int)($_ENV['DB_PORT'] ?? 3306);

// -----------------------------------------------------------------------------
// CONNECT TO DATABASE
// -----------------------------------------------------------------------------

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $link = mysqli_connect($DB_SERVER, $DB_USERNAME, $DB_PASSWORD, $DB_NAME, $DB_PORT);
    mysqli_set_charset($link, "utf8mb4");
} catch (mysqli_sql_exception $e) {
    // In production, you might want to log this instead of outputting the error
    die("Database Connection Failed: " . $e->getMessage());
}

// -----------------------------------------------------------------------------
// READY
// -----------------------------------------------------------------------------
?>