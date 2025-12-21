<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'image_path', 'is_active', 'sequence'];

    protected $casts = [
        'is_active' => 'boolean',
        'sequence' => 'integer',
    ];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        return $this->image_path ? \Illuminate\Support\Facades\Storage::url($this->image_path) : null;
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
