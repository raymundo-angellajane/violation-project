<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('students', function (Blueprint $table) {
            $table->id('student_id'); // PK
            $table->string('student_no');
            $table->string('first_name');
            $table->string('last_name');
            $table->unsignedBigInteger('course_id'); 
            $table->enum('year_level', ['1st Year', '2nd Year', '3rd Year', '4th Year']);

            $table->string('email')->unique();
            $table->string('contact_no', 20);
            $table->string('password'); 
            $table->rememberToken(); 
            $table->timestamps();

            $table->foreign('course_id')
                  ->references('course_id')
                  ->on('courses')
                  ->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('students');
    }
};
