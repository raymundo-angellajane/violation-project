<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        Student::create([
            'student_no' => '2025-0001',
            'first_name' => 'Test',
            'last_name' => 'Student',
            'course_id' => 1, // make sure a course with ID=1 exists in `courses` table
            'year_level' => '1st Year',
            'email' => 'student@test.com',
            'contact_no' => '09123456789',
            'password' => Hash::make('password1234'),
        ]);
    }
}
