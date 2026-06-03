<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'stock',
        'price',
    ];

     protected $dates = [
        'created_at',
        'updated_at',
    ];
}
