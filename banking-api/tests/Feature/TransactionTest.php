<?php
namespace Tests\Feature;

use App\Models\Account;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function processDebitTransaction()
    {

        $account = Account::create([
            'number_account' => 234,
            'balance' => 200.00,
        ]);

        $transactionAmount = 10.00;
        $debitFee = 0.03 * $transactionAmount;
        $totalAmount = $transactionAmount + $debitFee;

        $response = $this->postJson('/api/transaction', [
            'payment_method' => 'D',
            'number_account' => $account->number_account,
            'transaction_amount' => $transactionAmount,
        ]);

        $account->refresh();
        $response->assertStatus(201);
        $response->assertJson([
            'number_account' => $account->number_account,
            'balance' => 200.00 - $totalAmount,
        ]);
    }

    /** @test */
    public function processCreditTransaction()
    {

        $account = Account::create([
            'number_account' => 234,
            'balance' => 200.00,
        ]);

        $transactionAmount = 10.00;
        $creditFee = 0.05 * $transactionAmount;
        $totalAmount = $transactionAmount + $creditFee;

        $response = $this->postJson('/api/transaction', [
            'payment_method' => 'C',
            'number_account' => $account->number_account,
            'transaction_amount' => $transactionAmount,
        ]);

        $account->refresh();

        $response->assertStatus(201);
        $response->assertJson([
            'number_account' => $account->number_account,
            'balance' => 200.00 - $totalAmount,
        ]);
    }


    /** @test */
    public function processPixTransaction()
    {

        $account = Account::create([
            'number_account' => 234,
            'balance' => 200.00,
        ]);

        $transactionAmount = 10.00;
        $response = $this->postJson('/api/transaction', [
            'payment_method' => 'P',
            'number_account' => $account->number_account,
            'transaction_amount' => $transactionAmount,
        ]);

        $account->refresh();
        $response->assertStatus(201);
        $response->assertJson([
            'number_account' => $account->number_account,
            'balance' => 200.00 - $transactionAmount,
        ]);
    }

    /** @test */
    public function insufficientBalance()
    {
        $account = Account::create([
            'number_account' => 234,
            'balance' => 5.00,
        ]);

        $transactionAmount = 10.00;
        $response = $this->postJson('/api/transaction', [
            'payment_method' => 'D',
            'number_account' => $account->number_account,
            'transaction_amount' => $transactionAmount,
        ]);

        $response->assertStatus(404);
        $response->assertJson([
            'error' => 'INSUFFICIENT BALANCE',
        ]);

        $this->assertEquals(5.00, $account->fresh()->balance);
    }

    /** @test */
    public function invalidPaymentMethod()
    {
        $account = Account::create([
            'number_account' => 234,
            'balance' => 100.00,
        ]);

        $transactionAmount = 10.00;
        $invalidPaymentMethod = 'X';
        $response = $this->postJson('/api/transaction', [
            'payment_method' => $invalidPaymentMethod,
            'number_account' => $account->number_account,
            'transaction_amount' => $transactionAmount,
        ]);

        $response->assertStatus(422);
        $response->assertJson([
            'error' => 'The selected payment method is invalid.',
        ]);

        $this->assertEquals(100.00, $account->fresh()->balance);
    }

}

