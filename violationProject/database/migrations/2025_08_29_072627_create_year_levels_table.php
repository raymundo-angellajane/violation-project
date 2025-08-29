<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('year_levels', function (Blueprint $table) {
            $table->id('year_level_id');
            $table->string('year_name'); // 1st Year, 2nd Year, etc.
            $table->timestamps();
        });

        Schema::table('students', function (Blueprint $table) {
            $table->unsignedBigInteger('year_level_id')->nullable();

            $table->foreign('year_level_id')
                ->references('year_level_id')->on('year_levels')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('year_levels');
    }
};
