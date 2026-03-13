<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Testimonial extends Model
{
    protected $fillable = [
        'website_id', 'author_name', 'author_email', 'author_role',
        'customer_image', 'reviewed_at', 'content', 'rating', 'status', 'is_featured',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'reviewed_at' => 'date',
    ];

    public function website(): BelongsTo
    {
        return $this->belongsTo(Website::class);
    }

    /** Scope testimonials belonging to a given user's websites. */
    public function scopeForUser(Builder $query, int $userId): Builder
    {
        return $query->whereHas('website', fn ($q) => $q->where('user_id', $userId));
    }

    public function starString(): string
    {
        return str_repeat('★', $this->rating) . str_repeat('☆', 5 - $this->rating);
    }
}
