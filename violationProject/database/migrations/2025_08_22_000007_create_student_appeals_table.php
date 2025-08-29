<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('student_appeals', function (Blueprint $table) {
            $table->string('student_appeal_id')->primary();

            $table->unsignedBigInteger('student_id');
            $table->foreign('student_id')->references('student_id')->on('students')->cascadeOnDelete();

            $table->unsignedBigInteger('violation_id');
            $table->foreign('violation_id')->references('violation_id')->on('violations')->cascadeOnDelete();

            $table->string('appeal_id');
            $table->foreign('appeal_id')->references('appeal_id')->on('appeals')->cascadeOnDelete();

            $table->enum('status', ['Pending', 'Approved', 'Rejected'])->default('Pending');

            $table->string('reviewed_by')->nullable();
            $table->foreign('reviewed_by')->references('faculty_id')->on('faculties')->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_appeals');
    }
};



