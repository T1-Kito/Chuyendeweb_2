<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'customer_name',
        'customer_phone',
        'customer_email',
        'customer_address',
        'notes',
        'subtotal',
        'total_amount',
        'payment_method',
        'status',
        'rental_start_date',
        'rental_end_date',
        'total_months',
    ];

    protected $casts = [
        'rental_start_date' => 'date',
        'rental_end_date' => 'date',
        'subtotal' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public static function generateOrderNumber(): string
    {
        $prefix = 'ORD';
        $date = now()->format('Ymd');
        $random = strtoupper(substr(md5(uniqid()), 0, 6));
        return "{$prefix}{$date}{$random}";
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match($this->status) {
            'pending' => 'bg-warning',
            'confirmed' => 'bg-info',
            'processing' => 'bg-primary',
            'completed' => 'bg-success',
            'cancelled' => 'bg-danger',
            default => 'bg-secondary'
        };
    }

    public function getStatusTextAttribute(): string
    {
        return match($this->status) {
            'pending' => 'Chờ xác nhận',
            'confirmed' => 'Đã xác nhận',
            'processing' => 'Đang xử lý',
            'completed' => 'Hoàn thành',
            'cancelled' => 'Đã hủy',
            default => $this->status
        };
    }

    public function getIsActiveRentalAttribute(): bool
    {
        $now = Carbon::now();
        return $this->rental_start_date <= $now && $this->rental_end_date >= $now;
    }

    public function getIsExpiredAttribute(): bool
    {
        return $this->rental_end_date < Carbon::now();
    }

    public function getDaysRemainingAttribute(): int
    {
        if ($this->is_expired) {
            return $this->rental_end_date->diffInDays(Carbon::now());
        }
        return Carbon::now()->diffInDays($this->rental_end_date, false);
    }

    public function getRentalPeriodTextAttribute(): string
    {
        return $this->rental_start_date->format('d/m/Y') . ' - ' . $this->rental_end_date->format('d/m/Y');
    }
}
