<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['account_id', 'payment_method', 'transaction_amount', 'transaction_fee'];

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

}
