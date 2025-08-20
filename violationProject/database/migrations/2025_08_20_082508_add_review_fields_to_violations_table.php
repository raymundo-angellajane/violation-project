<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('violations', function (Blueprint $table) {
            if (!Schema::hasColumn('violations', 'appeal')) {
                $table->text('appeal')->nullable();
            }
            $table->string('reviewed_by')->nullable();
            $table->timestamp('reviewed_at')->nullable();
        });
    }

    public function down(): void {
        Schema::table('violations', function (Blueprint $table) {
            $table->dropColumn(['reviewed_by', 'reviewed_at']);
            // $table->dropColumn('appeal'); // only if you added it above
        });
    }
};
