<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insert or update a test Student
        DB::table('students')->updateOrInsert(
            ['email' => 'student@test.com'],
            [
                'student_no' => '2025-0001',
                'first_name' => 'John',
                'last_name' => 'Doe',
                'course_id' => 1, // change if your course table requires a valid ID
                'year_level' => 2,
                'contact_no' => '09123456789',
                'password' => Hash::make('123456'),
            ]
        );

        // Insert or update a test Faculty
        DB::table('faculties')->updateOrInsert(
            ['email' => 'faculty@test.com'],
            [
                'faculty_id' => 'F001', // must be unique
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'password' => Hash::make('123456'),
            ]
        );
    }
}
