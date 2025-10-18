<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'rental_duration', // 6, 12, 24 months
        'quantity',
        'price_per_month',
        'total_price',
    ];

    protected $casts = [
        'rental_duration' => 'integer',
        'quantity' => 'integer',
        'price_per_month' => 'decimal:0',
        'total_price' => 'decimal:0',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getFormattedTotalPriceAttribute()
    {
        return number_format($this->total_price) . 'đ';
    }

    public function getFormattedPricePerMonthAttribute()
    {
        return number_format($this->price_per_month) . 'đ/tháng';
    }
}
