<?php

function getDB() {
    static $db = null;
    if ($db === null) {
        $dbPath = __DIR__ . '/sakari.db';
        $db = new PDO('sqlite:' . $dbPath);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $db->exec("PRAGMA journal_mode=WAL");
        $db->exec("PRAGMA foreign_keys=ON");
        initTables($db);
    }
    return $db;
}

function initTables($db) {
    // Users table
    $db->exec("CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username TEXT NOT NULL UNIQUE,
        password TEXT NOT NULL,
        name TEXT NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");

    // Blog posts table
    $db->exec("CREATE TABLE IF NOT EXISTS blog_posts (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        title TEXT NOT NULL,
        excerpt TEXT,
        content TEXT,
        category TEXT DEFAULT 'General',
        badge_color TEXT DEFAULT '',
        image_url TEXT,
        author_name TEXT,
        author_role TEXT,
        author_img TEXT,
        read_time TEXT DEFAULT '5 min read',
        is_featured INTEGER DEFAULT 0,
        status TEXT DEFAULT 'published',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");

    // Jobs table
    $db->exec("CREATE TABLE IF NOT EXISTS jobs (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        title TEXT NOT NULL,
        description TEXT,
        type TEXT DEFAULT 'Full-time',
        category TEXT DEFAULT 'clinical',
        location TEXT DEFAULT 'Remote (Philippines)',
        shift TEXT DEFAULT 'Flexible',
        salary TEXT,
        tags TEXT,
        status TEXT DEFAULT 'published',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");

    // Seed default admin if no users exist
    $count = $db->query("SELECT COUNT(*) FROM users")->fetchColumn();
    if ($count == 0) {
        $hash = password_hash('admin123', PASSWORD_DEFAULT);
        $stmt = $db->prepare("INSERT INTO users (username, password, name) VALUES (?, ?, ?)");
        $stmt->execute(['admin', $hash, 'Administrator']);
        seedData($db);
    }
}

function seedData($db) {
    // Seed blog posts
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
        $stmt->execute([$b['title'], $b['excerpt'], $b['content'], $b['category'], $b['badge_color'], $b['image_url'], $b['author_name'], $b['author_role'], $b['author_img'], $b['read_time'], $b['is_featured'], $b['status']]);
    }

    // Seed jobs
    $jobs = [
        [
            'title' => 'Virtual Utilization Management Nurse',
            'description' => 'Perform concurrent and retrospective reviews using MCG/InterQual criteria. Collaborate with case managers and physicians to ensure appropriate level of care.',
            'type' => 'Full-time',
            'category' => 'clinical',
            'location' => 'Remote (Philippines)',
            'shift' => 'Night Shift (US Hours)',
            'salary' => '₱40,000 - ₱55,000/mo',
            'tags' => 'RN License,MCG/InterQual,UM Experience',
            'status' => 'published',
        ],
        [
            'title' => 'Virtual Care Coordinator',
            'description' => 'Manage transitions of care for patients, coordinate between hospitals, skilled nursing facilities, and home health agencies to ensure continuity of care.',
            'type' => 'Full-time',
            'category' => 'clinical',
            'location' => 'Remote (Philippines)',
            'shift' => 'Flexible Shift',
            'salary' => '₱35,000 - ₱50,000/mo',
            'tags' => 'RN License,Care Coordination,EHR Systems',
            'status' => 'published',
        ],
        [
            'title' => 'Medical Transcriptionist',
            'description' => 'Accurately transcribe and review clinician progress notes, discharge summaries, and medical reports with quick turnaround times.',
            'type' => 'Full-time',
            'category' => 'admin',
            'location' => 'Remote (Philippines)',
            'shift' => 'Day Shift',
            'salary' => '₱25,000 - ₱35,000/mo',
            'tags' => 'Medical Terminology,Typing 60+ WPM,Detail-Oriented',
            'status' => 'published',
        ],
        [
            'title' => 'Medical Billing & Coding Specialist',
            'description' => 'Handle ICD-10 coding, claims submission, denial management, and revenue cycle follow-ups to maximize reimbursement for healthcare clients.',
            'type' => 'Part-time',
            'category' => 'admin',
            'location' => 'Remote (Philippines)',
            'shift' => 'Flexible Hours',
            'salary' => '₱20,000 - ₱30,000/mo',
            'tags' => 'ICD-10 Certified,Revenue Cycle,Claims Processing',
            'status' => 'published',
        ],
        [
            'title' => 'Virtual Patient Navigator',
            'description' => 'Guide patients through their healthcare journey, providing education, appointment reminders, and resource referrals to improve care adherence and outcomes.',
            'type' => 'Full-time',
            'category' => 'clinical',
            'location' => 'Remote (Philippines)',
            'shift' => 'Day/Mid Shift',
            'salary' => '₱30,000 - ₱40,000/mo',
            'tags' => 'RN/Allied Health,Patient Education,Communication',
            'status' => 'published',
        ],
        [
            'title' => 'Healthcare Sales & Outreach Specialist',
            'description' => 'Drive client acquisition through outbound outreach, lead qualification, and relationship building with healthcare organizations across the U.S. market.',
            'type' => 'Full-time',
            'category' => 'sales',
            'location' => 'Remote (Philippines)',
            'shift' => 'US Business Hours',
            'salary' => '₱25,000 - ₱35,000/mo + Commission',
            'tags' => 'B2B Sales,Healthcare,CRM Tools',
            'status' => 'published',
        ],
    ];

    $stmt = $db->prepare("INSERT INTO jobs (title, description, type, category, location, shift, salary, tags, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    foreach ($jobs as $j) {
        $stmt->execute([$j['title'], $j['description'], $j['type'], $j['category'], $j['location'], $j['shift'], $j['salary'], $j['tags'], $j['status']]);
    }
}
