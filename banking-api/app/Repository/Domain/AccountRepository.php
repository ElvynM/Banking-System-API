<?php

namespace App\Repository\Domain;

use App\Models\Account;
use App\Repository\contracts\AccountRepositoryInterface;

class AccountRepository implements AccountRepositoryInterface
{
    public function create(array $data)
    {
        return Account::create($data);
    }

    public function findByNumber(int $number_account)
    {
        return Account::where('number_account', $number_account)->first();
    }
}
