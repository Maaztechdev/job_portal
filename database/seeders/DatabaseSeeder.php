<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Job;
use App\Models\Application;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create Employer
        $employer = User::create([
            'name' => 'Tech Solutions Inc.',
            'email' => 'employer@example.com',
            'password' => Hash::make('password'),
            'role' => 'employer',
        ]);

        // Create Seeker
        $seeker = User::create([
            'name' => 'John Doe',
            'email' => 'seeker@example.com',
            'password' => Hash::make('password'),
            'role' => 'seeker',
        ]);

        // Create Jobs
        $jobs = [
            [
                'title' => 'Senior Laravel Developer',
                'description' => "We are looking for an experienced Laravel Developer to join our team.\n\nRequirements:\n- 5+ years of PHP experience\n- Strong Laravel skills\n- Experience with MySQL and Redis\n- Knowledge of frontend technologies is a plus.",
                'location' => 'Remote',
                'category' => 'Engineering',
                'salary' => '$80,000 - $120,000',
                'type' => 'remote',
                'employer_id' => $employer->id,
            ],
            [
                'title' => 'UI/UX Designer',
                'description' => "Join our creative team to build beautiful user interfaces.\n\nRequirements:\n- Proficiency in Figma/Adobe XD\n- Understanding of user-centered design\n- Portfolio demonstrating modern web designs.",
                'location' => 'New York, NY',
                'category' => 'Design',
                'salary' => '$60,000 - $90,000',
                'type' => 'full-time',
                'employer_id' => $employer->id,
            ],
            [
                'title' => 'Marketing Manager',
                'description' => "Lead our marketing efforts and grow our brand presence.\n\nRequirements:\n- Experience in digital marketing\n- Strong analytical skills\n- Excellent communication.",
                'location' => 'London, UK',
                'category' => 'Marketing',
                'salary' => '£45,000 - £65,000',
                'type' => 'full-time',
                'employer_id' => $employer->id,
            ],
        ];

        foreach ($jobs as $jobData) {
            Job::create($jobData);
        }
    }
}
