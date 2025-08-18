<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('violations', function (Blueprint $table) {
        $table->id();
        $table->string('student_no');
        $table->string('name');
        $table->string('course');
        $table->string('year_level');
        $table->string('type');
        $table->text('details')->nullable();
        $table->date('date');
        $table->string('penalty');
        $table->string('status')->default('Pending');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('violations');
    }
};
