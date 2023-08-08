<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image',
        'product_qty',
        'subtitle',
        'product_id'
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
