<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('student_appeals', function (Blueprint $table) {
            $table->string('student_appeal_id', 50)->primary();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('violation_id');
            $table->string('appeal_id', 50);
            $table->enum('status', ['Pending', 'Approved', 'Rejected'])->default('Pending');
            $table->string('reviewed_by', 50)->nullable();
            $table->timestamps();

            $table->foreign('student_id')
                  ->references('student_id')
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
                ->references('faculty_id')
                ->on('faculties')
                ->onDelete('set null');
        });
    }

    public function down(): void {
        Schema::dropIfExists('student_appeals');
    }
};
