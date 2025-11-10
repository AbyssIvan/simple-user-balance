<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

#[OA\Schema(
    properties: [
        new OA\Property(property: 'user_id', description: 'User ID', type: 'integer', example: 1),
        new OA\Property(property: 'amount', description: 'Transaction amount', type: 'float', example: 350.56),
        new OA\Property(property: 'comment', description: 'Transaction comment', type: 'string', example: 'Transaction detail', nullable: true),
    ],
    example: [
        "user_id" => 1,
        "amount"  => 350.56,
        "comment" => 'Transaction detail',
    ]
)]
class TransactionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @psalm-return array<string, ValidationRule|array|string>
     */
    public function rules() : array
    {
        return [
            'user_id' => 'required|integer',
            'amount'  => 'required|numeric|min:0',
            'comment' => 'nullable|string',
        ];
    }
}
