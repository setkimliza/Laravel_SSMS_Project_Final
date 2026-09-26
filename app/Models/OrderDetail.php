<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $table = 'order_details';
    protected $primaryKey = 'OrderDetailID';

    protected $fillable = [
        'OrderID',
        'PID',
        'Quantity',
        'Price',
        'Subtotal',
    ];

    protected function casts(): array
    {
        return [
            'Quantity' => 'integer',
            'Price' => 'decimal:2',
            'Subtotal' => 'decimal:2',
        ];
    }

    /**
     * Order relationship.
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'OrderID', 'OrderID');
    }

    /**
     * Product relationship.
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'PID', 'PID');
    }
}
