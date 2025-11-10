<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class UserController extends Controller
{
    public function index(): JsonResource
    {
        $users = User::with(['transactions'])->orderByDesc('id')->get();

        UserResource::withoutWrapping();

        return UserResource::collection($users);
    }

    public function store(UserRequest $request): JsonResponse
    {
        $user = User::create($request->validated());

        return response()->json(['id' => $user->getKey(), 'message' => 'User successfully created'], JsonResponse::HTTP_CREATED);
    }

    public function show(int $userId): JsonResource
    {
        UserResource::withoutWrapping();

        return UserResource::make(User::findOrFail($userId));
    }

    public function update(UserRequest $request, int $userId): JsonResponse
    {
        $user = User::findOrFail($userId);
        $user->update($request->validated());

        return response()->json(['message' => "User successfully updated"], JsonResponse::HTTP_OK);
    }

    public function destroy(int $userId): JsonResponse
    {
        $user = User::findOrFail($userId);
        $user->delete();

        return response()->json(['message' => "User successfully deleted"], JsonResponse::HTTP_OK);
    }

    public function balance(int $userId): JsonResponse
    {
        $user = User::findOrFail($userId);

        return response()->json([
            "user_id" => $user->id,
            "balance" => $user->formatBalance(),
        ], JsonResponse::HTTP_OK);
    }
}
