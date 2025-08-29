<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('appeals', function (Blueprint $table) {
            $table->string('appeal_id')->primary(); // string ID
            $table->text('appeal_text');
            $table->enum('status', ['Pending', 'Approved', 'Rejected'])->default('Pending'); // ✅ status added
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appeals');
    }
};

