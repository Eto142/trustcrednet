<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Website extends Model
{
    protected $fillable = ['user_id', 'name', 'slug', 'url', 'description', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    /** Generate a slug from $name that is unique across the websites table. */
    public static function generateUniqueSlug(string $name, int $excludeId = 0): string
    {
        $base = Str::slug($name) ?: 'website';
        $slug = $base;
        $i    = 1;
        while (static::where('slug', $slug)->where('id', '!=', $excludeId)->exists()) {
            $slug = $base . '-' . $i++;
        }
        return $slug;
    }

    /** Full public URL for this business profile. */
    public function getPublicUrlAttribute(): string
    {
        return url('/' . $this->slug);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function testimonials(): HasMany
    {
        return $this->hasMany(Testimonial::class);
    }

    public function approvedTestimonials(): HasMany
    {
        return $this->testimonials()->where('status', 'approved');
    }
}
