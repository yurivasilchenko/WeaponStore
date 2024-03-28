<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/*class Product extends Model
{
    use HasFactory;
}*/
class Product extends Model
{
    protected $fillable = ['name', 'price', 'quantity', 'description', 'image', 'type'];

    // Your other model logic
}

