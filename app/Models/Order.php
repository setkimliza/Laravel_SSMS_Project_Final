<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $primaryKey = 'OrderID';

    protected $fillable = [
        'UserID',
        'TotalAmount',
        'OrderDate',
        'Status',
        'payment_method',
        'shipping_address',
        'customer_notes',
    ];

    protected function casts(): array
    {
        return [
            'TotalAmount' => 'decimal:2',
            'OrderDate' => 'datetime',
        ];
    }

    /**
     * User/Customer relationship.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'UserID', 'id');
    }

    /**
     * OrderDetails relationship.
     */
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'OrderID', 'OrderID');
    }

    /**
     * Alias for orderDetails.
     */
    public function details()
    {
        return $this->orderDetails();
    }

    /**
     * Status badge class helper.
     */
    public function getStatusBadgeAttribute(): string
    {
        return match (strtolower($this->Status)) {
            'completed' => 'bg-success',
            'processing' => 'bg-primary',
            'pending' => 'bg-warning text-dark',
            'cancelled' => 'bg-danger',
            default => 'bg-secondary',
        };
    }
}
