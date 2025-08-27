<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ViolationSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('violations')->insert([
            'violation_id' => 1,
            'student_id' => 1, 
            'description' => 'Wearing improper uniform',
            'status' => 'Pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
