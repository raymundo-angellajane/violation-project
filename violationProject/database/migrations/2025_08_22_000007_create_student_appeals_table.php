<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('student_appeals', function (Blueprint $table) {
            $table->string('student_appeal_id', 50)->primary();
            $table->unsignedBigInteger('student_no');
            $table->string('violation_id', 50);
            $table->string('appeal_id', 50);
            $table->enum('status', ['Pending', 'Approved', 'Rejected'])->default('Pending');
            $table->string('reviewed_by', 50)->nullable();
            $table->timestamps();

            $table->foreign('student_no')
                  ->references('student_no')
                  ->on('students')
                  ->onDelete('cascade');

            $table->foreign('violation_id')
                  ->references('violation_id')
                  ->on('violations')
                  ->onDelete('cascade');

            $table->foreign('appeal_id')
                  ->references('appeal_id')
                  ->on('appeals')
                  ->onDelete('cascade');

            $table->foreign('reviewed_by')
                  ->references('reviewer_id')
                  ->on('reviewers')
                  ->onDelete('set null');
        });
    }

    public function down(): void {
        Schema::dropIfExists('student_appeals');
    }
};
