<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('violations', function (Blueprint $table) {
            $table->id('violation_id');
            
            $table->unsignedBigInteger('student_id');
            $table->foreign('student_id')->references('student_id')->on('students')->cascadeOnDelete();

            $table->unsignedBigInteger('course_id');
            $table->foreign('course_id')->references('course_id')->on('courses')->cascadeOnDelete();

            $table->string('year_level');
            $table->string('type');
            $table->text('details')->nullable();
            $table->date('violation_date');
            $table->string('penalty');
            $table->enum('status', ['Pending', 'Cleared', 'Disclosed'])->default('Pending');
            $table->string('reviewed_by')->nullable(); 
            $table->foreign('reviewed_by')->references('faculty_id')->on('faculties')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::table('violations', function (Blueprint $table) {
            $table->dropForeign(['student_id']);
            $table->dropForeign(['course_id']);
            $table->dropForeign(['reviewed_by']);
        });

        Schema::dropIfExists('violations');
    }
};
