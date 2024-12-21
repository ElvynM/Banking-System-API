<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = ['number_account', 'balance'];

    public function transacoes()
    {
        return $this->hasMany(Transaction::class, 'account_id');
    }
}
