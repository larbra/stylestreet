<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tovar extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'price',
        'description',
        'category',
        'image'
    ];

    // Связь с дополнительными изображениями
    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }
}
