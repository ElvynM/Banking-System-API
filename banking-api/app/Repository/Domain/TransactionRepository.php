<?php

namespace App\Repository\Domain;

use App\Models\Account;
use App\Models\Transaction;
use App\Repository\contracts\TransactionRepositoryInterface;
use Illuminate\Validation\ValidationException;
class TransactionRepository implements TransactionRepositoryInterface
{
    public function validateTransaction(array $data): array
    {
        $rules = [
            'payment_method' => 'required|in:P,C,D',
            'number_account' => 'required|integer|exists:accounts,number_account',
            'transaction_amount' => 'required|numeric|gte:0',
        ];
        return validator($data, $rules)->validate();
    }

    public function calculateFee(string $method, float $amount): float
    {
        return match ($method) {
            'D' => $amount * 0.03,
            'C' => $amount * 0.05,
            'P' => 0,
            default => throw ValidationException::withMessages(['payment_method' => 'Invalid payment method']),
        };
    }

    public function processTransaction(array $validatedData): Account
    {
        $account = Account::where('number_account', $validatedData['number_account'])->firstOrFail();

        $fee = $this->calculateFee($validatedData['payment_method'], $validatedData['transaction_amount']);
        $total = round($validatedData['transaction_amount'] + $fee, 2);

        if ($account->balance < $total) {
            throw new \Exception('INSUFFICIENT BALANCE', 404);
        }

        $account->balance -= $total;
        $account->balance = round($account->balance, 2);
        $account->save();

        Transaction::create([
            'account_id' => $account->id,
            'payment_method' => $validatedData['payment_method'],
            'transaction_amount' => $validatedData['transaction_amount'],
            'transaction_fee' => $fee,
        ]);
        return $account;
    }
}
