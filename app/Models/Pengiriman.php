<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengiriman extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = 'pengirimen';
    protected $fillable = [
        'id_history_transaksi',
        'user_id',
        'nama_penerima',
        'total_harga',
        'alamat_penerima',
        'patokan_penerima',
        'status_pengiriman',
        'created_date',
        'created_time',
        'send_date',
        'send_time',
        'created_at',
        'updated_at'
    ];
}
