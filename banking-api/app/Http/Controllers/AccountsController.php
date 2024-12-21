<?php

namespace App\Http\Controllers;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AccountsController extends Controller
{
    public function create(Request $request)
    {
        try{
            $validation =  $request->validate([
                'number_account' => 'required|integer|unique:accounts,number_account',
                'balance' => 'required|numeric|min:0',
            ],);

            $accounts = Account::create($validation);
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
        $account = Account::where('number_account', $number_account)->first();

        if(!$account){
            return response()->json(['message' => 'Account not found'], 404);
        }
        return response()->json($account, 200);
    }
}
