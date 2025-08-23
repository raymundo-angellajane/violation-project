<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('violations', function (Blueprint $table) {
            $table->bigIncrements('violation_id')->change();
            $table->string('student_no');
            $table->string('first_name');   
            $table->string('last_name');
            $table->string('course_id');
            $table->string('year_level');
            $table->string('type');
            $table->date('violation_date');
            $table->string('penalty');
            $table->string('status');
            $table->unsignedBigInteger('reviewed_by')->nullable();
            $table->timestamps();  

            $table->foreign('student_no')
                  ->references('student_no')
                  ->on('students')
                  ->onDelete('cascade');

            $table->foreign('reviewed_by')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');
        });
    }

    public function down(): void {
        Schema::dropIfExists('violations');
    }
};
