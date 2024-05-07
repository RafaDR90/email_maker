<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'title',
        'pvp',
        'pvd',
        'url_imagen_compress',
        'url_producto',
        'oferta',
        'oferta_pvd',
    ];
}
