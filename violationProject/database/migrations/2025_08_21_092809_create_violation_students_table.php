<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('violation_students', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id')->nullable(); // replace later with foreign key
            $table->string('type');
            $table->text('details');
            $table->date('date');
            $table->string('penalty')->nullable();
            $table->text('appeal')->nullable();
            $table->enum('status', ['pending','disclosed','cleared'])->default('pending');
            $table->string('reviewed_by')->nullable(); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('violation_students');
    }
};

//for sample testing lang to dedmahin mo muna