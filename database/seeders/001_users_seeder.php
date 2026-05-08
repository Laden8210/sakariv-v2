<?php
/**
 * Seeder: Default admin user
 */

return new class {
    public function run(PDO $db): void
    {
        // Check if admin already exists
        $stmt = $db->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
        $stmt->execute(['admin']);
        if ($stmt->fetchColumn() > 0) {
            echo "  ⏭  Admin user already exists, skipping.\n";
            return;
        }

        $stmt = $db->prepare("INSERT INTO users (username, password, name, email, role) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([
            'admin',
            password_hash('admin123', PASSWORD_DEFAULT),
            'Administrator',
            'admin@sakarimanagement.com',
            'admin',
        ]);

        echo "  ✅ Admin user created (username: admin, password: admin123)\n";
    }
};
