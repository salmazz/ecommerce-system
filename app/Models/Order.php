<?php

namespace App\Models;

use App\Enums\Order\OrderStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'total_price', 'status'];
    protected $casts = [
        'status' => OrderStatusEnum::class,
    ];
    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->withPivot('quantity', 'price_at_purchase')
            ->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
