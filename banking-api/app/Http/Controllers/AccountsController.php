<?php

namespace App\Http\Controllers;
use App\Repository\contracts\AccountRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AccountsController extends Controller
{
    private $accountRepository;
    public function __construct(AccountRepositoryInterface $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    public function create(Request $request)
    {
        try{
            $validation =  $request->validate([
                'number_account' => 'required|integer|unique:accounts,number_account',
                'balance' => 'required|numeric|min:0',
            ],);

            $accounts = $this->accountRepository->create($validation);
            return response()->json($accounts, 201);

        }catch(ValidationException $e){

            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $e->validator->errors(),
            ], 422);
        }

    }

    public function show($number_account)
    {
        $account = $this->accountRepository->findByNumber($number_account);

        if(!$account){
            return response()->json(['message' => 'Account not found'], 404);
        }
        return response()->json($account, 200);
    }
}
