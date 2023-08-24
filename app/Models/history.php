<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class history extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = 'histories';
    protected $fillable = [
        'user_id',
        'history_id',
        'nama_produk',
        'jumlah',
        'harga',
        'created_at',
        'updated_at'
    ];
}
