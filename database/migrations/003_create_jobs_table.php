<?php
/**
 * Migration: Create jobs table
 */

return new class {
    public function up(PDO $db): void
    {
        $db->exec("CREATE TABLE IF NOT EXISTS jobs (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(500) NOT NULL,
            description TEXT,
            type VARCHAR(50) DEFAULT 'Full-time',
            category VARCHAR(50) DEFAULT 'clinical',
            location VARCHAR(255) DEFAULT 'Remote (Philippines)',
            shift VARCHAR(100) DEFAULT 'Flexible',
            salary VARCHAR(100),
            tags VARCHAR(500),
            status ENUM('published', 'draft') DEFAULT 'published',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX idx_status (status),
            INDEX idx_category (category),
            INDEX idx_type (type)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    }

    public function down(PDO $db): void
    {
        $db->exec("DROP TABLE IF EXISTS jobs");
    }
};
