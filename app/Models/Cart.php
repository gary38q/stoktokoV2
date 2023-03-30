<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = 'carts';
    protected $fillable = [
        'cart_SKU',
        'Jumlah',
        'created_at',
        'updated_at'
    ];
}
