<?php
namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TransactionController extends Controller
{
    public function create(Request $request)
    {
        try {
            $validated = $request->validate([
                'payment_method' => 'required|in:P,C,D',
                'number_account' => 'required|integer|exists:accounts,number_account',
                'transaction_amount' => 'required|numeric|gte:0',
            ]);
        } catch (ValidationException $e) {
            $errorMessages = $e->validator->errors()->all();
            if (isset($errorMessages[0])) {
                return response()->json([
                    'error' => $errorMessages[0],
                ], 422);
            }
        }

        $account = Account::where('number_account', $validated['number_account'])->first();

        $fee = 0;

        switch ($validated['payment_method']) {
            case 'D':
                $fee = $validated['transaction_amount'] * 0.03;
                break;
            case 'C':
                $fee = $validated['transaction_amount'] * 0.05;
                break;
            case 'P':
                $fee = 0;
                break;
            default:

        }

        $total = round($validated['transaction_amount'] + $fee, 2);

        if ($account->balance < $total) {
            return response()->json(['error' => 'INSUFFICIENT BALANCE'], 404);
        }

        $account->balance -= $total;
        $account->balance = round($account->balance, 2);
        $account->save();

        Transaction::create([
            'account_id' => $account->id,
            'payment_method' => $validated['payment_method'],
            'transaction_amount' => $validated['transaction_amount'],
            'transaction_fee' => $fee,
        ]);

        return response()->json([
            'number_account' => $account->number_account,
            'balance' => $account->balance,
        ], 201);
    }
}
