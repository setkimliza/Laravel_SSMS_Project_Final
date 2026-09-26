<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $primaryKey = 'PID';

    protected $fillable = [
        'PName',
        'Qty',
        'MinStock',
        'Price',
        'ExpiredDate',
        'CatID',
        'image',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'Qty' => 'integer',
            'MinStock' => 'integer',
            'Price' => 'decimal:2',
            'ExpiredDate' => 'date',
        ];
    }

    /**
     * Category relationship.
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'CatID', 'CatID');
    }

    /**
     * OrderDetails relationship.
     */
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'PID', 'PID');
    }

    /**
     * Check if product is low on stock.
     */
    public function isLowStock(): bool
    {
        return $this->Qty > 0 && $this->Qty <= $this->MinStock;
    }

    /**
     * Check if product is out of stock.
     */
    public function isOutOfStock(): bool
    {
        return $this->Qty <= 0;
    }

    /**
     * Check if product is expired.
     */
    public function isExpired(): bool
    {
        return $this->ExpiredDate && Carbon::parse($this->ExpiredDate)->isPast();
    }

    /**
     * Check if product is expiring soon within N days.
     */
    public function isExpiringSoon(int $days = 30): bool
    {
        if (!$this->ExpiredDate) {
            return false;
        }
        $date = Carbon::parse($this->ExpiredDate);
        return $date->isFuture() && $date->lte(Carbon::now()->addDays($days));
    }

    /**
     * Scope for low stock products.
     */
    public function scopeLowStock($query)
    {
        return $query->whereColumn('Qty', '<=', 'MinStock');
    }

    /**
     * Scope for expired products.
     */
    public function scopeExpired($query)
    {
        return $query->whereNotNull('ExpiredDate')->where('ExpiredDate', '<=', Carbon::today());
    }

    /**
     * Scope for expiring soon products.
     */
    public function scopeExpiringSoon($query, int $days = 30)
    {
        return $query->whereNotNull('ExpiredDate')
            ->where('ExpiredDate', '>', Carbon::today())
            ->where('ExpiredDate', '<=', Carbon::today()->addDays($days));
    }

    /**
     * Get image URL or placeholder.
     */
    public function getImageUrlAttribute(): string
    {
        if ($this->image && file_exists(public_path($this->image))) {
            return asset($this->image);
        }
        if ($this->image && file_exists(public_path('images/' . $this->image))) {
            return asset('images/' . $this->image);
        }
        if ($this->image && file_exists(public_path('storage/' . $this->image))) {
            return asset('storage/' . $this->image);
        }
        if ($this->image && (str_starts_with($this->image, 'http') || str_starts_with($this->image, 'https'))) {
            return $this->image;
        }
        // Fallback SVG or default
        return asset('images/product-placeholder.svg');
    }
}
