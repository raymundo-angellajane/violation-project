<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('reviewers', function (Blueprint $table) {
            $table->string('reviewer_id', 50)->primary();
            $table->string('faculty_id', 50);
            $table->timestamps();

            $table->foreign('faculty_id')->references('faculty_id')->on('faculties')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('reviewers');
    }
};
