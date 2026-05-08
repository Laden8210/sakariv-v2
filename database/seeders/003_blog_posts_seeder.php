<?php
/**
 * Seeder: Sample blog posts
 */

return new class {
    public function run(PDO $db): void
    {
        $count = $db->query("SELECT COUNT(*) FROM blog_posts")->fetchColumn();
        if ($count > 0) {
            echo "  ⏭  Blog posts already exist ($count found), skipping.\n";
            return;
        }

        $blogs = [
            [
                'title' => 'The Future of Virtual Healthcare Staffing: Trends to Watch in 2026',
                'excerpt' => 'As healthcare organizations face mounting pressure to reduce costs while maintaining quality, virtual staffing solutions are transforming how care is delivered.',
                'content' => 'As healthcare organizations face mounting pressure to reduce costs while maintaining quality, virtual staffing solutions are transforming how care is delivered. From AI-assisted documentation to remote utilization management, the landscape is evolving rapidly. Organizations that embrace virtual staffing are seeing unprecedented cost savings while maintaining—and often improving—the quality of patient care.',
                'category' => 'Industry Trends',
                'badge_color' => '',
                'image_url' => 'https://images.unsplash.com/photo-1576091160550-2173dba999ef?auto=format&fit=crop&w=800&q=80',
                'author_name' => 'Van Cacho FNP-BC',
                'author_role' => 'CEO & Co-Founder',
                'author_img' => 'assets/img/team/van.jpg',
                'read_time' => '8 min read',
                'is_featured' => 1,
                'status' => 'published',
            ],
            [
                'title' => '5 Reasons Why Filipino Nurses Excel in Virtual Healthcare Roles',
                'excerpt' => 'The Philippines produces some of the world\'s most skilled and compassionate nurses. Here\'s why they\'re the perfect fit for virtual healthcare support positions.',
                'content' => 'The Philippines produces some of the world\'s most skilled and compassionate nurses. Here\'s why they\'re the perfect fit for virtual healthcare support positions. From their rigorous educational requirements to their natural empathy and strong English communication skills, Filipino nurses bring exceptional value to virtual healthcare teams.',
                'category' => 'Healthcare',
                'badge_color' => 'blue',
                'image_url' => 'https://images.unsplash.com/photo-1579684385127-1ef15d508118?auto=format&fit=crop&w=600&q=80',
                'author_name' => 'Dr. Joshua Cacho',
                'author_role' => 'Co-Founder',
                'author_img' => 'assets/img/team/josh.jpg',
                'read_time' => '5 min read',
                'is_featured' => 0,
                'status' => 'published',
            ],
            [
                'title' => 'HIPAA Compliance in Remote Healthcare: What You Need to Know',
                'excerpt' => 'Protecting patient data is paramount in virtual healthcare settings. Learn the essential HIPAA compliance strategies every remote healthcare team should implement.',
                'content' => 'Protecting patient data is paramount in virtual healthcare settings. Learn the essential HIPAA compliance strategies every remote healthcare team should implement. This guide covers encryption requirements, secure communication protocols, and workforce training essentials.',
                'category' => 'Best Practices',
                'badge_color' => 'green',
                'image_url' => 'https://images.unsplash.com/photo-1551076805-e1869033e561?auto=format&fit=crop&w=600&q=80',
                'author_name' => 'Van Cacho FNP-BC',
                'author_role' => 'CEO & Co-Founder',
                'author_img' => 'assets/img/team/van.jpg',
                'read_time' => '6 min read',
                'is_featured' => 0,
                'status' => 'published',
            ],
            [
                'title' => 'How Outsourcing Utilization Management Saves Healthcare Systems Millions',
                'excerpt' => 'Discover how strategic outsourcing of utilization management can dramatically reduce operational costs while improving patient outcomes and compliance rates.',
                'content' => 'Discover how strategic outsourcing of utilization management can dramatically reduce operational costs while improving patient outcomes and compliance rates. Real-world case studies show organizations saving up to 60% on UM operations while maintaining quality metrics.',
                'category' => 'Cost Savings',
                'badge_color' => 'purple',
                'image_url' => 'https://images.unsplash.com/photo-1516549655169-df83a0774514?auto=format&fit=crop&w=600&q=80',
                'author_name' => 'Mike Austria BSN, RN',
                'author_role' => 'VP, Business Development',
                'author_img' => 'assets/img/team/mike.jpeg',
                'read_time' => '4 min read',
                'is_featured' => 0,
                'status' => 'published',
            ],
            [
                'title' => 'Building a Remote-First Healthcare Culture: Lessons from Sakari',
                'excerpt' => 'Creating a high-performance remote team requires more than technology. Learn how we build culture, trust, and accountability across continents.',
                'content' => 'Creating a high-performance remote team requires more than technology. Learn how we build culture, trust, and accountability across continents. Our approach combines structured onboarding, regular team rituals, and performance frameworks that keep everyone aligned.',
                'category' => 'Leadership',
                'badge_color' => 'orange',
                'image_url' => 'https://images.unsplash.com/photo-1573497620053-ea5300f94f21?auto=format&fit=crop&w=600&q=80',
                'author_name' => 'Van Cacho FNP-BC',
                'author_role' => 'CEO & Co-Founder',
                'author_img' => 'assets/img/team/van.jpg',
                'read_time' => '7 min read',
                'is_featured' => 0,
                'status' => 'published',
            ],
            [
                'title' => 'The Role of Virtual Medical Transcription in Modern Healthcare',
                'excerpt' => 'Medical transcription is evolving. See how virtual transcriptionists are improving turnaround times and accuracy with dedicated focus and advanced tools.',
                'content' => 'Medical transcription is evolving. See how virtual transcriptionists are improving turnaround times and accuracy with dedicated focus and advanced tools. The shift to remote transcription has opened access to a global talent pool while reducing overhead costs significantly.',
                'category' => 'Healthcare',
                'badge_color' => '',
                'image_url' => 'https://images.unsplash.com/photo-1587854692152-cbe660dbde88?auto=format&fit=crop&w=600&q=80',
                'author_name' => 'Dr. Joshua Cacho',
                'author_role' => 'Co-Founder',
                'author_img' => 'assets/img/team/josh.jpg',
                'read_time' => '5 min read',
                'is_featured' => 0,
                'status' => 'published',
            ],
            [
                'title' => 'A Complete Guide to Onboarding Your Virtual Healthcare Assistant',
                'excerpt' => 'Setting your virtual assistant up for success starts with effective onboarding. Follow our proven framework for seamless integration into your clinical workflows.',
                'content' => 'Setting your virtual assistant up for success starts with effective onboarding. Follow our proven framework for seamless integration into your clinical workflows. Includes checklists, training schedules, and communication protocols.',
                'category' => 'Guides',
                'badge_color' => 'green',
                'image_url' => 'https://images.unsplash.com/photo-1504868584819-f8e8b4b6d7e3?auto=format&fit=crop&w=600&q=80',
                'author_name' => 'Mike Austria BSN, RN',
                'author_role' => 'VP, Business Development',
                'author_img' => 'assets/img/team/mike.jpeg',
                'read_time' => '6 min read',
                'is_featured' => 0,
                'status' => 'published',
            ],
        ];

        $stmt = $db->prepare("INSERT INTO blog_posts (title, excerpt, content, category, badge_color, image_url, author_name, author_role, author_img, read_time, is_featured, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        foreach ($blogs as $b) {
            $stmt->execute([
                $b['title'], $b['excerpt'], $b['content'], $b['category'],
                $b['badge_color'], $b['image_url'], $b['author_name'],
                $b['author_role'], $b['author_img'], $b['read_time'],
                $b['is_featured'], $b['status'],
            ]);
        }

        echo "  ✅ Seeded " . count($blogs) . " blog posts\n";
    }
};
