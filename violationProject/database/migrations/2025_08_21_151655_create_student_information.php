<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('student_information', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('course_year_level', 50);
            $table->string('email', 50);
            $table->string('contact_number', 15);

        });
    }

    public function down(): void {
        Schema::dropIfExists('student_information');
    }
};
