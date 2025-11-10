<?php

declare(strict_types=1);

namespace App\Http\SpecScheme;

use App\Http\Requests\TransactionRequest;
use App\Http\Requests\TransferRequest;
use App\Http\Requests\UserRequest;
use OpenApi\Attributes as OA;

#[OA\Info(version: '1.0.0', title: 'OpenApi documentation')]
#[OA\Get(
    path: '/api/users',
    summary: 'Get users list',
    tags: ['#User'],
    responses: [
        new OA\Response(
            response: 200,
            description: 'Success response',
            content: new OA\JsonContent(type: 'array', items: new OA\Items(properties: [
                new OA\Property(property: 'id', type: 'integer', example: 2),
                new OA\Property(property: 'name', type: 'string', example: 'Some name'),
                new OA\Property(property: 'balance', type: 'float', example: 321.12),
                new OA\Property(property: 'createdAt', type: 'string', example: '05.11.2025 13:15:42'),
                new OA\Property(property: 'updatedAt', type: 'string', example: '06.11.2025 15:15:42'),
            ]))
        ),
    ]
)]
#[OA\Post(
    path: "/api/users",
    summary: 'Create user',
    requestBody: new OA\RequestBody(
        required: true,
        content: new OA\JsonContent(type: UserRequest::class)
    ),
    tags: ['#User'],
    responses: [
        new OA\Response(
            response: 200,
            description: 'User successfully created',
            content: new OA\JsonContent(example: ['message' => 'User successfully created'])
        ),
    ]
)]
#[OA\Get(
    path: '/api/users/{id}',
    summary: 'Get user info',
    tags: ['#User'],
    responses: [
        new OA\Response(
            response: 200,
            description: 'Success response',
            content: new OA\JsonContent(type: 'object', properties: [
                new OA\Property(property: 'id', type: 'integer', example: 2),
                new OA\Property(property: 'name', type: 'string', example: 'Some name'),
                new OA\Property(property: 'balance', type: 'float', example: 321.12),
                new OA\Property(property: 'createdAt', type: 'string', example: '05.11.2025 13:15:42'),
                new OA\Property(property: 'updatedAt', type: 'string', example: '06.11.2025 15:15:42'),
            ])
        ),
    ]
)]
#[OA\Put(
    path: "/api/users/{id}",
    summary: 'Update user',
    requestBody: new OA\RequestBody(
        required: true,
        content: new OA\JsonContent(type: UserRequest::class)
    ),
    tags: ['#User'],
    parameters: [new OA\Parameter(name: 'id', description: 'Entity id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'), examples: ['' => new OA\Examples(example: 'id', summary: 'id', value: 19)])],
    responses: [
        new OA\Response(
            response: 200,
            description: 'User successfully updated',
            content: new OA\JsonContent(example: ['message' => 'User successfully updated'])
        ),
    ]
)]
#[OA\Delete(
    path: "/api/users/{id}",
    summary: 'Delete user',
    tags: ['#User'],
    parameters: [new OA\Parameter(name: 'id', description: 'Entity id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'), examples: ['' => new OA\Examples(example: 'id', summary: 'id', value: 19)])],
    responses: [
        new OA\Response(
            response: 200,
            description: 'User successfully deleted',
            content: new OA\JsonContent(example: ['message' => 'User successfully deleted'])
        ),
    ]
)]
#[OA\Get(
    path: '/api/balance/{id}',
    summary: 'Get user balance',
    tags: ['#User'],
    responses: [
        new OA\Response(
            response: 200,
            description: 'Success response',
            content: new OA\JsonContent(type: 'object', properties: [
                new OA\Property(property: 'user_id', type: 'integer', example: 2),
                new OA\Property(property: 'balance', type: 'float', example: 321.12),
            ])
        ),
    ]
)]
#[OA\Post(
    path: '/api/deposit',
    summary: 'Deposit funds for user',
    requestBody: new OA\RequestBody(
        required: true,
        content: new OA\JsonContent(type: TransactionRequest::class)
    ),
    tags: ['#Transaction'],
    responses: [
        new OA\Response(
            response: 200,
            description: 'User balance updated',
            content: new OA\JsonContent(example: ['message' => 'User balance updated'])
        ),
    ]
)]
#[OA\Post(
    path: '/api/withdraw',
    summary: 'Withdraw funds for user',
    requestBody: new OA\RequestBody(
        required: true,
        content: new OA\JsonContent(type: TransactionRequest::class)
    ),
    tags: ['#Transaction'],
    responses: [
        new OA\Response(
            response: 200,
            description: 'User balance updated',
            content: new OA\JsonContent(example: ['message' => 'User balance updated'])
        ),
    ]
)]
#[OA\Post(
    path: '/api/transfer',
    summary: 'Transfer funds between users',
    requestBody: new OA\RequestBody(
        required: true,
        content: new OA\JsonContent(type: TransferRequest::class)
    ),
    tags: ['#Transaction'],
    responses: [
        new OA\Response(
            response: 200,
            description: 'User balance updated',
            content: new OA\JsonContent(example: ['message' => 'User balance updated'])
        ),
    ]
)]
class OpenApiSpec
{
}
