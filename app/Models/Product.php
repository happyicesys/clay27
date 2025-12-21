<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'price',
        'image_path',
        'description',
        'is_active',
        'category_id',
        'is_bestseller',
        'sequence',
        'stock',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_bestseller' => 'boolean',
        'sequence' => 'integer',
        'stock' => 'integer',
        'price' => 'decimal:2',
    ];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        return $this->image_path ? \Illuminate\Support\Facades\Storage::url($this->image_path) : null;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sequence');
    }
}
