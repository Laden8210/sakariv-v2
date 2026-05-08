<?php
/**
 * Seeder: Sample job postings
 */

return new class {
    public function run(PDO $db): void
    {
        $count = $db->query("SELECT COUNT(*) FROM jobs")->fetchColumn();
        if ($count > 0) {
            echo "  ⏭  Jobs already exist ($count found), skipping.\n";
            return;
        }

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
            $stmt->execute([
                $j['title'], $j['description'], $j['type'], $j['category'],
                $j['location'], $j['shift'], $j['salary'], $j['tags'], $j['status'],
            ]);
        }

        echo "  ✅ Seeded " . count($jobs) . " job postings\n";
    }
};
