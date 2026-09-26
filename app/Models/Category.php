<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $primaryKey = 'CatID';

    protected $fillable = [
        'name',
        'description',
        'icon',
    ];

    /**
     * Get products in this category.
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'CatID', 'CatID');
    }
}
