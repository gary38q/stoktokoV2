<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class historyid extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = 'historyids';
    protected $fillable = [
        'id',
        'user_id',
        'total_qty',
        'total_harga',
        'created_at',
        'updated_at'
    ];
}
