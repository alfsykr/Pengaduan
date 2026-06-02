<?php
/**
 * Database Migration Runner via CLI
 * Run this command from terminal: php migrate.php
 */
declare(strict_types=1);

// Load database configuration
require_once __DIR__ . '/config/database.php';

// Check if running from CLI
if (PHP_SAPI !== 'cli') {
    die("This script can only be run from the command line (CLI).\n");
}

echo "===========================================\n";
echo "       DATABASE MIGRATION RUNNER           \n";
echo "===========================================\n";

try {
    // 1. Establish initial connection to MySQL (without dbname) to ensure the DB exists
    $dsnWithoutDb = "mysql:host=" . DB_HOST . ";charset=" . DB_CHARSET;
    $pdoInit = new PDO($dsnWithoutDb, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
    
    echo "Checking database: `" . DB_NAME . "`...\n";
    $pdoInit->exec("CREATE DATABASE IF NOT EXISTS `" . DB_NAME . "` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $pdoInit = null; // Close connection
    echo "Database `" . DB_NAME . "` is ready.\n\n";
    
    // 2. Establish connection to the actual database
    $db = getDB();
    
    // 3. Create migrations logging table to keep track of already applied migrations
    $db->exec("CREATE TABLE IF NOT EXISTS `migrations_log` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `migration_name` VARCHAR(255) UNIQUE NOT NULL,
        `applied_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
    
    // 4. Sequential list of database files
    $migrations = [
        'pengaduan3.sql',                     // Base DB structure & seed data
        'dukcapil_mandiri.sql',               // Base schema for kependudukan digital
        'migration_profil.sql',               // User profile columns expansion
        'migration_kk.sql',                   // Kartu Keluarga column adjustments
        'migration_ktp.sql',                  // KTP column adjustments
        'migration_pindah.sql',               // Pindah domisili tables & relations
        'migration_kelahiran_kematian.sql',   // Birth & Death tables
        'migration_pengaduan_baru.sql',       // Citizen complaints with GPS coordinates & photo uploads
        'migration_lurah.sql'                 // Add lurah role support
    ];
    
    $dir = __DIR__ . '/database/';
    
    foreach ($migrations as $migration) {
        $filePath = $dir . $migration;
        if (!file_exists($filePath)) {
            echo "[WARNING] Migration file not found: $migration\n";
            continue;
        }
        
        // Check if this migration was already applied
        $stmt = $db->prepare("SELECT COUNT(*) as count FROM migrations_log WHERE migration_name = ?");
        $stmt->execute([$migration]);
        $alreadyRun = (int) $stmt->fetch()['count'] > 0;
        
        if ($alreadyRun) {
            echo "[SKIP] $migration (Already applied)\n";
            continue;
        }
        
        echo "[APPLYING] $migration...\n";
        
        $sql = file_get_contents($filePath);
        if ($sql === false || trim($sql) === '') {
            echo "[SKIP] $migration (Empty file)\n";
            continue;
        }
        
        // Execute the SQL statements
        $db->exec($sql);
        
        // Record in log table
        $stmt = $db->prepare("INSERT INTO migrations_log (migration_name) VALUES (?)");
        $stmt->execute([$migration]);
        
        echo "[SUCCESS] Applied $migration successfully.\n";
    }
    
    echo "===========================================\n";
    echo "All migrations processed successfully!\n";
    
} catch (\Exception $e) {
    echo "\n[ERROR] Migration failed:\n" . $e->getMessage() . "\n";
    exit(1);
}
