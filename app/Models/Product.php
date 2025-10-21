<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'features',
        'image',
        'slug',
        'category_id',
        'daily_price',
        'weekly_price',
        'monthly_price',
        'stock_quantity',
        'status',
        'is_featured',
        'is_active',
        // Thêm các trường mới
        'min_rental_months',
        'price_1_month',
        'price_6_months',
        'price_12_months',
        'price_18_months',
        'price_24_months',
        'promotion_badge',
        'promotion_description',
        'promotion_start_date',
        'promotion_end_date',
        'warranty_info',
        'has_warranty_support',
        'rental_terms',
        'delivery_info',
        'specs',
        'serial_number',
        'model'
    ];

    protected $casts = [
        'daily_price' => 'decimal:2',
        'weekly_price' => 'decimal:2',
        'monthly_price' => 'decimal:2',
        'price_1_month' => 'decimal:2',
        'price_6_months' => 'decimal:2',
        'price_12_months' => 'decimal:2',
        'price_18_months' => 'decimal:2',
        'price_24_months' => 'decimal:2',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'has_warranty_support' => 'boolean',
        'promotion_start_date' => 'date',
        'promotion_end_date' => 'date'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function rentalItems(): HasMany
    {
        return $this->hasMany(RentalItem::class);
    }

    public function getFormattedPriceAttribute()
    {
        return '₫' . number_format($this->daily_price, 0, ',', '.');
    }

    public function getImageUrlAttribute(): string
    {
        if ($this->image) {
            // Normalize to a site-relative storage URL to avoid APP_URL issues on mobile
            $path = ltrim($this->image, '/');
            if (Str::startsWith($path, 'storage/')) {
                return '/' . $path;
            }
            if (Str::startsWith($path, 'public/')) {
                $path = substr($path, 7); // remove leading 'public/'
            }
            return asset('storage/' . $path);
        }
        return 'https://via.placeholder.com/400x300/f3f4f6/6b7280?text=No+Image';
    }

    // Kiểm tra xem sản phẩm có đang khuyến mãi không
    public function getIsPromotionActiveAttribute()
    {
        if (!$this->promotion_badge) return false;
        
        $now = Carbon::now();
        $startDate = $this->promotion_start_date;
        $endDate = $this->promotion_end_date;
        
        if (!$startDate && !$endDate) return true; // Không có ngày = luôn active
        
        if ($startDate && $now->lt($startDate)) return false;
        if ($endDate && $now->gt($endDate)) return false;
        
        return true;
    }

    // Lấy giá theo tháng
    public function getPriceByMonths($months)
    {
        switch ($months) {
            case 6: return $this->price_6_months;
            case 12: return $this->price_12_months;
            case 18: return $this->price_18_months;
            case 24: return $this->price_24_months;
            default: return $this->price_6_months;
        }
    }

    // Format giá theo tháng
    public function getFormattedPriceByMonths($months)
    {
        $price = $this->getPriceByMonths($months);
        return $price ? '₫' . number_format($price, 0, ',', '.') : 'Liên hệ';
    }

    // Tính % giảm giá so với giá 6 tháng
    public function getDiscountPercentage($months)
    {
        $basePrice = $this->price_6_months;
        $currentPrice = $this->getPriceByMonths($months);
        
        if (!$basePrice || !$currentPrice || $months <= 6) return 0;
        
        $discount = (($basePrice * $months) - $currentPrice) / ($basePrice * $months) * 100;
        return round($discount, 1);
    }
}
