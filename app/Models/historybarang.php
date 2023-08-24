<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class historybarang extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = 'historybarangs';
    protected $fillable = [
        'user_id',
        'SKU_produk',
        'nama_produk',
        'Pengirim',
        'Jumlah',
        'created_at',
        'updated_at'
    ];
}
