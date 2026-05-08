<?php
/**
 * Seeder: Default site settings
 */

return new class {
    public function run(PDO $db): void
    {
        $settings = [
            // General
            ['site_name',        'Sakari Management Group',                      'general', 'Website name displayed across the site'],
            ['site_tagline',     'Empowering Healthcare Through Virtual Support','general', 'Short tagline or slogan'],
            ['site_email',       'agency@sakarimanagement.com',                  'general', 'Primary contact email'],
            ['site_phone_us',    '+19097232671',                                 'general', 'US phone number'],
            ['site_phone_ph',    '+639171686148',                                'general', 'Philippines phone number'],
            ['site_address',     '2011 Palomar Airport Road, Suite 101, Carlsbad CA 92011 United States', 'general', 'Physical address'],

            // Social
            ['social_facebook',  'https://www.facebook.com/profile.php?id=61573640922847', 'social', 'Facebook page URL'],
            ['social_instagram', '',                                             'social', 'Instagram profile URL'],
            ['social_linkedin',  '',                                             'social', 'LinkedIn company URL'],
            ['social_twitter',   '',                                             'social', 'Twitter/X profile URL'],

            // SEO
            ['meta_description', 'Empowering healthcare through exceptional virtual support. Sakari Management Group provides skilled virtual assistants for utilization management, care coordination, billing, transcription, and more.', 'seo', 'Default meta description'],
            ['meta_keywords',    'Sakari Management Group, virtual healthcare assistants, healthcare outsourcing, utilization management, care coordination', 'seo', 'Default meta keywords'],
            ['og_image',         'https://sakariwellness.com/images/og-image.jpg', 'seo', 'Default Open Graph image URL'],

            // Branding
            ['primary_color',    '#4f46e5',                                      'branding', 'Primary brand color (hex)'],
            ['accent_color',     '#6366f1',                                      'branding', 'Accent color (hex)'],
            ['logo_path',        'assets/img/logo.png',                          'branding', 'Path to site logo'],

            // External
            ['calendly_url',     'https://calendly.com/junettecacho-sakarimanagement/30min', 'external', 'Calendly booking URL for Apply Now buttons'],
        ];

        $stmt = $db->prepare("INSERT IGNORE INTO settings (setting_key, setting_value, setting_group, description) VALUES (?, ?, ?, ?)");

        $count = 0;
        foreach ($settings as $s) {
            $stmt->execute($s);
            $count += $stmt->rowCount();
        }

        echo "  ✅ Seeded $count settings (" . count($settings) . " total, existing ones skipped)\n";
    }
};
