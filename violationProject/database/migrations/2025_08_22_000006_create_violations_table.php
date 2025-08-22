<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('violations', function (Blueprint $table) {
            $table->string('violation_id', 50)->primary();
            $table->unsignedBigInteger('student_no');
            $table->string('details', 255);
            $table->enum('status', ['Pending', 'Approved', 'Rejected'])->default('Pending');
            $table->string('penalty', 100)->nullable();
            $table->enum('type', ['Minor', 'Major']);
            $table->date('violation_date');
            $table->string('reviewed_by', 50)->nullable();
            $table->timestamps();

            $table->foreign('student_no')
                  ->references('student_no')
                  ->on('students')
                  ->onDelete('cascade');

            $table->foreign('reviewed_by')
                  ->references('reviewer_id')
                  ->on('reviewers')
                  ->onDelete('set null');
        });
    }

    public function down(): void {
        Schema::dropIfExists('violations');
    }
};
