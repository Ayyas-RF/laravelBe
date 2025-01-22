<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        "category_id",
        "product_name",
        "product_image",
        "product_image_name",
        "price",
        "stock",
        "description"
    ];
}
