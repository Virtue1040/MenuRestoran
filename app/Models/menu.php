<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class menu extends Model
{
    /** @use HasFactory<\Database\Factories\MenuFactory> */
    use HasFactory;

    protected $fillable = [
        'id_user',
        'judul',
        'kategori',
        'imageUrl',
        'asal',
    ];

    protected $primaryKey = 'id_menu';
}
