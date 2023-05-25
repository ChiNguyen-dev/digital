<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'order_id', 'quantity', 'color_id'];

    public function product(): HasOne
    {
        return $this->hasOne(Product::class, 'product_id');
    }

    public function color(): HasOne
    {
        return $this->hasOne(Color::class, 'color_id');
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
