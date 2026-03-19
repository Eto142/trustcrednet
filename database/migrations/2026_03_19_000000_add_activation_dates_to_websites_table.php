<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('websites', function (Blueprint $table) {
            $table->timestamp('activated_at')->nullable()->after('is_active');
            $table->timestamp('activation_expires_at')->nullable()->after('activated_at');
        });
    }

    public function down(): void
    {
        Schema::table('websites', function (Blueprint $table) {
            $table->dropColumn(['activated_at', 'activation_expires_at']);
        });
    }
};
