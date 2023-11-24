<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Fortify\TwoFactorAuthenticatable;

class Transaction extends Model
{
    use HasFactory, TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'client_id',
        'sender_id',
        'recipient_id',
        'amount_sent',
    ];
}
