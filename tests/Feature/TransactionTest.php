<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    use RefreshDatabase;
    
    public function testDepositUserDontExists() : void
    {
        $response = $this
            ->withHeaders([
                'Accept'       => 'application/json',
                'Content-Type' => 'application/json',
                'BalanceAuth'  => env('CUSTOM_AUTH_SECRET'),
            ])
            ->postJson('/api/deposit', [
                "user_id" => 1,
                "amount"  => 350.59,
                "comment" => "Transaction detail",
            ]);

        $response->assertStatus(404);
    }
    
    public function testDepositSuccess() : void
    {
        $userId   = $this->createUser();
        $response = $this
            ->withHeaders([
                'Accept'       => 'application/json',
                'Content-Type' => 'application/json',
                'BalanceAuth'  => env('CUSTOM_AUTH_SECRET'),
            ])
            ->postJson('/api/deposit', [
                "user_id" => $userId,
                "amount"  => 350.59,
                "comment" => "Transaction detail",
            ]);

        $response->assertStatus(201);
        $this->checkBalance($userId, 350.59);
    }
    
    public function testWithdrawSuccess() : void
    {
        $userId   = $this->createUser();
        $response = $this
            ->withHeaders([
                'Accept'       => 'application/json',
                'Content-Type' => 'application/json',
                'BalanceAuth'  => env('CUSTOM_AUTH_SECRET'),
            ])
            ->postJson('/api/deposit', [
                "user_id" => $userId,
                "amount"  => 350.59,
                "comment" => "Transaction detail",
            ]);

        $response->assertStatus(201);
        $this->checkBalance($userId, 350.59);

        $response = $this
            ->withHeaders([
                'Accept'       => 'application/json',
                'Content-Type' => 'application/json',
                'BalanceAuth'  => env('CUSTOM_AUTH_SECRET'),
            ])
            ->postJson('/api/withdraw', [
                "user_id" => $userId,
                "amount"  => 100.59,
                "comment" => "Transaction detail",
            ]);

        $response->assertStatus(201);
        $this->checkBalance($userId, 250.0);
    }
    
    public function testWithdrawNegativeBalance() : void
    {
        $userId   = $this->createUser();
        $response = $this
            ->withHeaders([
                'Accept'       => 'application/json',
                'Content-Type' => 'application/json',
                'BalanceAuth'  => env('CUSTOM_AUTH_SECRET'),
            ])
            ->postJson('/api/deposit', [
                "user_id" => $userId,
                "amount"  => 350.59,
                "comment" => "Transaction detail",
            ]);

        $response->assertStatus(201);
        $this->checkBalance($userId, 350.59);

        $response = $this
            ->withHeaders([
                'Accept'       => 'application/json',
                'Content-Type' => 'application/json',
                'BalanceAuth'  => env('CUSTOM_AUTH_SECRET'),
            ])
            ->postJson('/api/withdraw', [
                "user_id" => $userId,
                "amount"  => 100000.59,
                "comment" => "Transaction detail",
            ]);

        $response->assertStatus(409);
    }
    
    public function testTransferSuccess() : void
    {
        $fromUserId = $this->createUser();
        $toUserId   = $this->createUser();

        //add balance for fromUser
        $response = $this
            ->withHeaders([
                'Accept'       => 'application/json',
                'Content-Type' => 'application/json',
                'BalanceAuth'  => env('CUSTOM_AUTH_SECRET'),
            ])
            ->postJson('/api/deposit', [
                "user_id" => $fromUserId,
                "amount"  => 200.0,
                "comment" => "Transaction detail",
            ]);

        $response->assertStatus(201);
        $this->checkBalance($fromUserId, 200.0);

        $response = $this
            ->withHeaders([
                'Accept'       => 'application/json',
                'Content-Type' => 'application/json',
                'BalanceAuth'  => env('CUSTOM_AUTH_SECRET'),
            ])
            ->postJson('/api/transfer', [
                "from_user_id" => $fromUserId,
                "to_user_id"   => $toUserId,
                "amount"       => 100.0,
                "comment"      => "Transaction detail",
            ]);

        $response->assertStatus(201);
        $this->checkBalance($toUserId, 100.0);
    }

    private function checkBalance(int $userId, float $balance) : void
    {
        $response = $this
            ->withHeaders([
                'BalanceAuth'  => env('CUSTOM_AUTH_SECRET'),
            ])
            ->get('/api/balance/' . $userId);

        $userBalance = json_decode($response->getContent(), true)['balance'];
        $this->assertEquals($userBalance, $balance);
    }

    private function createUser() : int
    {
        $userResponse = $this
            ->withHeaders([
                'Accept'       => 'application/json',
                'Content-Type' => 'application/json',
                'BalanceAuth'  => env('CUSTOM_AUTH_SECRET'),
            ])
            ->postJson('/api/users', [
                "name" => "Test user",
            ]);

        return json_decode($userResponse->getContent(), true)['id'];
    }
}
