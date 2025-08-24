<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('violations', function (Blueprint $table) {
            $table->bigIncrements('violation_id')->primary();
             $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('course_id');
            $table->string('year_level');
            $table->string('type');
            $table->string('details')->nullable();
            $table->date('violation_date');
            $table->string('penalty');
            $table->string('status');
            $table->string('reviewed_by', 50)->nullable();
            $table->timestamps();  

            $table->foreign('student_id')
                  ->references('student_id')
                  ->on('students')
                  ->onDelete('cascade');

            $table->foreign('course_id')
                  ->references('course_id')
                  ->on('courses')
                  ->onDelete('cascade');

            $table->foreign('reviewed_by')
                  ->references('faculty_id')
                  ->on('faculties')
                  ->onDelete('set null');
        });
    }

    public function down(): void {
        Schema::dropIfExists('violations');
    }
};
