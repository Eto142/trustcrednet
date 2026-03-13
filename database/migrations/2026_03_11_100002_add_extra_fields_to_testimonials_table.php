<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('testimonials', function (Blueprint $table) {
            $table->string('author_role')->nullable()->after('author_email');
            $table->string('customer_image')->nullable()->after('author_role');
            $table->date('reviewed_at')->nullable()->after('customer_image');
        });
    }

    public function down(): void
    {
        Schema::table('testimonials', function (Blueprint $table) {
            $table->dropColumn(['author_role', 'customer_image', 'reviewed_at']);
        });
    }
};
