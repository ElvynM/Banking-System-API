<?php

namespace App\Repository\contracts;

use App\Models\Account;

interface TransactionRepositoryInterface
{
    public function validateTransaction(array $data): array;

    public function calculateFee(string $method, float $amount): float;

    public function processTransaction(array $validatedData): Account;
}
