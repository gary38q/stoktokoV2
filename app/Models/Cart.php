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
        'user_id',
        'cart_SKU',
        'Jumlah',
        'created_at',
        'updated_at'
    ];
}
