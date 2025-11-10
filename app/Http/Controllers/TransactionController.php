<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enum\TransactionType;
use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionRequest;
use App\Http\Requests\TransferRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function deposit(TransactionRequest $request): JsonResponse
    {
        $user = User::findOrFail($request->validated('user_id'));

        DB::transaction(function () use ($user, $request) {
            $amount = (int) ($request->validated('amount') * 100);

            $user->modifyBalance($amount);
            $user->transactions()->create([
                'type'    => TransactionType::DEPOSIT,
                'amount'  => $amount,
                'comment' => $request->validated('comment'),
            ]);
            $user->save();
        });

        return response()->json(['message' => 'User balance updated'], JsonResponse::HTTP_CREATED);
    }

    public function withdraw(TransactionRequest $request): JsonResponse
    {
        $user = User::findOrFail($request->validated('user_id'));

        DB::transaction(function () use ($user, $request) {
            $amount = (int) ($request->validated('amount') * 100);

            $user->modifyBalance($amount * -1);
            $user->transactions()->create([
                'type'    => TransactionType::WITHDRAW,
                'amount'  => $amount,
                'comment' => $request->validated('comment'),
            ]);
            $user->save();
        });

        return response()->json(['message' => 'User balance updated'], JsonResponse::HTTP_CREATED);
    }

    public function transfer(TransferRequest $request): JsonResponse
    {
        $fromUser = User::findOrFail($request->validated('from_user_id'));
        $toUser = User::findOrFail($request->validated('to_user_id'));

        DB::transaction(function () use ($fromUser, $toUser, $request) {
            $amount = (int) ($request->validated('amount') * 100);

            $fromUser->modifyBalance($amount * -1);
            $fromUser->transactions()->create([
                'type'    => TransactionType::TRANSFER_OUT,
                'amount'  => $amount,
                'comment' => $request->validated('comment'),
            ]);

            $toUser->modifyBalance($amount);
            $toUser->transactions()->create([
                'type'     => TransactionType::TRANSFER_IN,
                'amount'   => $amount,
                'payer_id' => $fromUser->id,
                'comment'  => $request->validated('comment'),
            ]);

            $fromUser->save();
            $toUser->save();
        });

        return response()->json(['message' => 'User balance updated'], JsonResponse::HTTP_CREATED);
    }
}
