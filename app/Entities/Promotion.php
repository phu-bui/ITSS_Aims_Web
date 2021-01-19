<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $table = 'promotions';

    protected $fillable = [
        'promotionId', 'type', 'name', 'description', 'category_id', 'product_id', 'discount','num_product_discount','start_at','end_at'
    ];

    const PROMOTION_TYPE_1 = '1';
    const PROMOTION_TYPE_2 = '2';
    const PROMOTION_TYPE_3 = '3';

    public static $typePromotions = [
        self:: PROMOTION_TYPE_1 => 'Flash Sale',
        self:: PROMOTION_TYPE_2 => 'Big Sale',
        self:: PROMOTION_TYPE_3 => '12/12',
    ];


}
