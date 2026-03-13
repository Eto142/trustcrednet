<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        // Add nullable first so existing rows don't violate the constraint
        Schema::table('websites', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('name');
        });

        // Back-fill slugs for any existing websites
        $existing = DB::table('websites')->get();
        foreach ($existing as $website) {
            $base = Str::slug($website->name) ?: 'website';
            $slug = $base;
            $i    = 1;
            while (DB::table('websites')->where('slug', $slug)->where('id', '!=', $website->id)->exists()) {
                $slug = $base . '-' . $i++;
            }
            DB::table('websites')->where('id', $website->id)->update(['slug' => $slug]);
        }
    }

    public function down(): void
    {
        Schema::table('websites', function (Blueprint $table) {
            $table->dropUnique(['slug']);
            $table->dropColumn('slug');
        });
    }
};
