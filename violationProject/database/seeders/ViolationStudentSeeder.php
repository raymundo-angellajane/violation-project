<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ViolationStudent;
use Carbon\Carbon;

class ViolationStudentSeeder extends Seeder
{
    public function run(): void
    {
        ViolationStudent::create([
            'student_id' => 1,
            'type'       => 'Minor',
            'details'    => 'Did not wear school uniform.',
            'date'       => Carbon::now()->subDays(5),
            'penalty'    => 'Warning',
            'status'     => 'pending',
        ]);

        ViolationStudent::create([
            'student_id' => 1,
            'type'       => 'Major',
            'details'    => 'Cutting classes multiple times.',
            'date'       => Carbon::now()->subDays(10),
            'penalty'    => 'Community Service',
            'status'     => 'disclosed',
        ]);

        ViolationStudent::create([
            'student_id' => 1,
            'type'       => 'Severe',
            'details'    => 'Cheating during examination.',
            'date'       => Carbon::now()->subDays(20),
            'penalty'    => '1-week Suspension',
            'appeal'     => 'I was wrongly accused, please reconsider.',
            'status'     => 'pending',
        ]);
    }
}
