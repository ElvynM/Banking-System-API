<?php

namespace App\Http\Controllers;
use App\Repository\contracts\TransactionRepositoryInterface;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    private $transactionRepository;

    public function __construct(TransactionRepositoryInterface $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    public function create(Request $request)
    {
        try {
            $validatedData = $this->transactionRepository->validateTransaction($request->all());

            $account = $this->transactionRepository->processTransaction($validatedData);

            return response()->json([
                'number_account' => $account->number_account,
                'balance' => $account->balance,
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode() ?: 422);
        }
    }
}
