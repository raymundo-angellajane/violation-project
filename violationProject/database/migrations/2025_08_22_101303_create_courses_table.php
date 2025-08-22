<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('courses', function (Blueprint $table) {
            $table->id('course_id');
            $table->string('course_name', 100);
            $table->string('course_code', 20)->unique();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('courses');
    }
};