<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RentalItem extends Model
{
    protected $fillable = [
        'rental_id',
        'product_id',
        'quantity',
        'unit_price',
        'total_price',
        'rental_period'
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2'
    ];

    public function rental(): BelongsTo
    {
        return $this->belongsTo(Rental::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
