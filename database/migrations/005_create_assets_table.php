<?php
/**
 * Migration: Create assets table
 */

return new class {
    public function up(PDO $db): void
    {
        $db->exec("CREATE TABLE IF NOT EXISTS assets (
            id INT AUTO_INCREMENT PRIMARY KEY,
            filename VARCHAR(255) NOT NULL,
            original_name VARCHAR(500) NOT NULL,
            mime_type VARCHAR(100) NOT NULL,
            file_size INT UNSIGNED NOT NULL DEFAULT 0,
            width INT UNSIGNED DEFAULT NULL,
            height INT UNSIGNED DEFAULT NULL,
            alt_text VARCHAR(500) DEFAULT '',
            folder VARCHAR(100) DEFAULT 'general',
            uploaded_by INT DEFAULT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            INDEX idx_folder (folder),
            INDEX idx_mime (mime_type),
            INDEX idx_created (created_at)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    }

    public function down(PDO $db): void
    {
        $db->exec("DROP TABLE IF EXISTS assets");
    }
};
