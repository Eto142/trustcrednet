<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $primaryKey = 'key';
    public $incrementing  = false;
    protected $keyType    = 'string';
    protected $fillable   = ['key', 'value'];

    /** Get a setting value by key, with optional default. */
    public static function get(string $key, mixed $default = null): mixed
    {
        return static::where('key', $key)->value('value') ?? $default;
    }

    /** Set (upsert) a setting value. */
    public static function set(string $key, mixed $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    /** Return all payment-related settings as an associative array. */
    public static function payment(): array
    {
        $rows = static::whereIn('key', [
            'crypto_address', 'moniffy_tag', 'bank_name',
            'bank_account_number', 'bank_account_name',
            'whatsapp_number', 'price_usd',
        ])->pluck('value', 'key')->toArray();

        return array_merge([
            'crypto_address'      => '',
            'moniffy_tag'         => '@trustcrednet',
            'bank_name'           => '',
            'bank_account_number' => '',
            'bank_account_name'   => '',
            'whatsapp_number'     => '',
            'price_usd'           => '30',
        ], $rows);
    }
}
