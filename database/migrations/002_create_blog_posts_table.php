<?php
/**
 * Migration: Create blog_posts table
 */

return new class {
    public function up(PDO $db): void
    {
        $db->exec("CREATE TABLE IF NOT EXISTS blog_posts (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(500) NOT NULL,
            excerpt TEXT,
            content LONGTEXT,
            category VARCHAR(100) DEFAULT 'General',
            badge_color VARCHAR(50) DEFAULT '',
            image_url VARCHAR(500),
            author_name VARCHAR(255),
            author_role VARCHAR(255),
            author_img VARCHAR(500),
            read_time VARCHAR(50) DEFAULT '5 min read',
            is_featured TINYINT(1) DEFAULT 0,
            status ENUM('published', 'draft') DEFAULT 'published',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX idx_status (status),
            INDEX idx_featured (is_featured),
            INDEX idx_category (category)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    }

    public function down(PDO $db): void
    {
        $db->exec("DROP TABLE IF EXISTS blog_posts");
    }
};
