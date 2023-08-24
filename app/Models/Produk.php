<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = 'produks';
    protected $fillable = [
        'user_id',
        'Hapus',
        'nama_produk',
        'harga',
        'jumlah_stock',
        'created_at',
        'updated_at'
    ];
}
