<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Share extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'account_id',
        'stock_symbol',
        'price_bought',
        'current_price',
        'current_investment',
        'amount',
        'difference'
    ];
}
