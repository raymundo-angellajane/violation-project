<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('violations', function (Blueprint $table) {
            $table->string('violation_id', 50)->primary(); // Or use bigIncrements if preferred
            $table->unsignedBigInteger('student_no'); // Foreign key to students
            $table->string('details', 255);
            $table->enum('status', ['Pending', 'Approved', 'Rejected'])->default('Pending');
            $table->string('penalty', 100)->nullable();
            $table->enum('type', ['Minor', 'Major']);
            $table->date('violation_date');
            $table->timestamps();
            $table->string('reviewed_by', 50)->nullable();

            $table->foreign('student_no')->references('student_no')->on('students')->onDelete('cascade');
            $table->foreign('reviewed_by')->references('reviewer_id')->on('reviewers')->onDelete('set null');
        });

    }

    public function down(): void {
        Schema::dropIfExists('violations');
    }
};
