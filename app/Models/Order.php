<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'table_number',
        'notes',
        'status',
        'total_amount',
        'payment_received',
        'change',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
