<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('student_appeals', function (Blueprint $table) {
            $table->id('student_appeals_id');
            $table->string('student_id', 50);
            $table->unsignedBigInteger('violation_id');
            $table->unsignedBigInteger('appeals_id');
            $table->enum('status', ['Pending', 'Disclosed']);
            $table->timestamps();
            $table->string('reviewed_by', 50)->nullable();


        });
    }

    public function down(): void {
        Schema::dropIfExists('student_appeals');
    }
};
