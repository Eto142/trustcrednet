<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Table already exists — just seed default payment values if missing
        $defaults = [
            'crypto_address'      => '',
            'moniffy_tag'         => '@trustcrednet',
            'bank_name'           => 'Opay (OPay Digital Services)',
            'bank_account_number' => '',
            'bank_account_name'   => 'TrustCredNet Technologies',
            'whatsapp_number'     => '2348000000000',
            'price_usd'           => '30',
        ];
        $now = now();
        foreach ($defaults as $k => $v) {
            DB::table('settings')->insertOrIgnore([
                'key' => $k, 'value' => $v,
                'created_at' => $now, 'updated_at' => $now,
            ]);
        }
    }

    public function down(): void
    {
        DB::table('settings')->whereIn('key', [
            'crypto_address', 'moniffy_tag', 'bank_name',
            'bank_account_number', 'bank_account_name',
            'whatsapp_number', 'price_usd',
        ])->delete();
    }
};
