<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id('student_id');
            $table->string('student_no')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->unsignedBigInteger('course_id')->nullable();
            $table->foreign('course_id')->references('course_id')->on('courses')->cascadeOnDelete();
            $table->unsignedBigInteger('year_level_id')->nullable();
            $table->foreign('year_level_id')->references('year_level_id')->on('year_levels')->cascadeOnDelete();
            $table->string('email')->unique();
            $table->string('contact_no')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->timestamps();
            
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};

