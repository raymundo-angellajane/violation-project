<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Faculty;
use Illuminate\Support\Facades\Hash;

class FacultySeeder extends Seeder
{
    public function run(): void
    {
        Faculty::create([
            'faculty_id' => 'F001',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'faculty@test.com',
            'password' => Hash::make('password123'),
        ]);
    }
}
