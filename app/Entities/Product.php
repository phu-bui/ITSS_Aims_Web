<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
      'categoryId', 'idGood', 'title', 'value', 'image', 'price', 'description', 'quantity', 'language'
    ];

}
