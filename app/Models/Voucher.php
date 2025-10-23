<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class Voucher extends Model
{
    protected $fillable = [
        'code',
        'name',
        'description',
        'type',
        'value',
        'min_order_amount',
        'max_discount',
        'usage_limit',
        'used_count',
        'starts_at',
        'expires_at',
        'is_active'
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'min_order_amount' => 'decimal:2',
        'max_discount' => 'decimal:2',
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'is_active' => 'boolean'
    ];

    /**
     * Scope cho voucher đang hoạt động
     */
    public function scopeActive(Builder $query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope cho voucher còn hạn
     */
    public function scopeValid(Builder $query)
    {
        $now = now();
        return $query->where(function ($q) use ($now) {
            $q->whereNull('starts_at')
              ->orWhere('starts_at', '<=', $now);
        })->where(function ($q) use ($now) {
            $q->whereNull('expires_at')
              ->orWhere('expires_at', '>=', $now);
        });
    }

    /**
     * Scope cho voucher còn lượt sử dụng
     */
    public function scopeAvailable(Builder $query)
    {
        return $query->where(function ($q) {
            $q->whereNull('usage_limit')
              ->orWhereRaw('used_count < usage_limit');
        });
    }

    /**
     * Kiểm tra voucher có thể sử dụng không
     */
    public function isUsable()
    {
        if (!$this->is_active) {
            return false;
        }

        // Kiểm tra thời gian
        $now = now();
        if ($this->starts_at && $this->starts_at > $now) {
            return false;
        }
        if ($this->expires_at && $this->expires_at < $now) {
            return false;
        }

        // Kiểm tra lượt sử dụng
        if ($this->usage_limit && $this->used_count >= $this->usage_limit) {
            return false;
        }

        return true;
    }

    /**
     * Tính giá trị giảm giá
     */
    public function calculateDiscount($orderAmount)
    {
        if (!$this->isUsable()) {
            return 0;
        }

        // Kiểm tra đơn hàng tối thiểu
        if ($this->min_order_amount && $orderAmount < $this->min_order_amount) {
            return 0;
        }

        $discount = 0;
        
        if ($this->type === 'percentage') {
            $discount = ($orderAmount * $this->value) / 100;
        } else {
            $discount = $this->value;
        }

        // Áp dụng giảm tối đa
        if ($this->max_discount && $discount > $this->max_discount) {
            $discount = $this->max_discount;
        }

        return min($discount, $orderAmount);
    }

    /**
     * Tăng số lần sử dụng
     */
    public function incrementUsage()
    {
        $this->increment('used_count');
    }

    /**
     * Lấy trạng thái voucher
     */
    public function getStatusAttribute()
    {
        if (!$this->is_active) {
            return 'inactive';
        }

        if (!$this->isUsable()) {
            if ($this->expires_at && $this->expires_at < now()) {
                return 'expired';
            }
            if ($this->usage_limit && $this->used_count >= $this->usage_limit) {
                return 'limit_reached';
            }
            return 'unavailable';
        }

        return 'active';
    }

    /**
     * Lấy màu sắc theo trạng thái
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'active' => 'success',
            'inactive' => 'secondary',
            'expired' => 'danger',
            'limit_reached' => 'warning',
            'unavailable' => 'dark',
            default => 'secondary'
        };
    }

    /**
     * Lấy text trạng thái
     */
    public function getStatusTextAttribute()
    {
        return match($this->status) {
            'active' => 'Hoạt động',
            'inactive' => 'Tạm dừng',
            'expired' => 'Hết hạn',
            'limit_reached' => 'Hết lượt',
            'unavailable' => 'Không khả dụng',
            default => 'Không xác định'
        };
    }
}
