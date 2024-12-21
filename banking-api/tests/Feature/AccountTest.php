<?php

namespace Tests\Feature;

use App\Models\Account;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class AccountTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function createNewCount(){
        $response = $this->postJson('/api/accounts', [
            'number_account' => 234,
            'balance' => 100.00,
        ]);

        $response->assertStatus(201);

        return $response->json([
            'number_account' => 234,
            'balance' => 100.00
        ]);
    }
    /** @test */
    public function accountAlreadyExists(){

        Account::create([
            'number_account' => 234,
            'balance' => 100.00,
        ]);

        $response = $this->postJson('/api/accounts', [
            'number_account' => 234,
            'balance' => 200.00,
        ]);

        $response->assertStatus(422);
        $response->assertJsonFragment([
            'number_account' => ['The number account has already been taken.'],
        ]);
        $response->assertJsonValidationErrors('number_account');
    }
    /** @test */
    public function verifyAccountBalance()
    {
        $account = Account::create([
            'number_account' => 234,
            'balance' => 100.00,
        ]);

        $response = $this->getJson("/api/accounts/{$account->number_account}");
        $response->assertStatus(200);
        $response->assertJson([
            'number_account' => 234,
            'balance' => 100.00,
        ]);
    }
    /** @test */
    public function verifyAcountBalanceIsNotNegative()
    {
        $response = $this->postJson('/api/accounts', [
            'number_account' => 12345,
            'balance' => -100.00,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('balance');
        $response->assertJsonFragment([
            'balance' => ['The balance field must be at least 0.'],
        ]);
    }
}
