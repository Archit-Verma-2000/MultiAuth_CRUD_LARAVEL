<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Specify the table name if it doesn't follow Laravel's naming convention
    protected $table = 'tb_products';

    // Specify which attributes should be mass-assignable
    protected $fillable = [
        'Product_name',
        'Description',
        'price',
        'quantity',
        'weight',
        'dimensions',
        'image_url',
        'status',
    ];
}