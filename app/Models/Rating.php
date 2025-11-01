<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rating extends Model
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_HIDDEN = 'hidden';

    protected $fillable = [
        'product_id',
        'user_id',
        'stars',
        'content',
        'is_anonymous',
        'package_months',
        'status',
        'reviewed_at',
    ];

    protected $casts = [
        'is_anonymous' => 'boolean',
        'reviewed_at' => 'datetime',
    ];

    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_APPROVED);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getDisplayUserNameAttribute(): string
    {
        if ($this->is_anonymous || !$this->user) {
            return __('Ẩn danh');
        }

        $name = $this->user->name ?? __('Người dùng');

        if (mb_strlen($name) <= 2) {
            return mb_substr($name, 0, 1) . '***';
        }

        return mb_substr($name, 0, 1) . str_repeat('*', max(1, mb_strlen($name) - 2)) . mb_substr($name, -1);
    }
}


