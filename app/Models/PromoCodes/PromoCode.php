<?php

namespace App\Models\PromoCodes;

use Illuminate\Database\Eloquent\Model;

class PromoCode extends Model
{
    protected $table = 'promo_codes';
    public $timestamps = true;
    protected $fillable = ['code','date'];

}
