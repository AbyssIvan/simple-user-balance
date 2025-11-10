<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

#[OA\Schema(
    properties: [
        new OA\Property(property: 'from_user_id', description: 'From user ID', type: 'integer', example: 1),
        new OA\Property(property: 'to_user_id', description: 'To user ID', type: 'integer', example: 2),
        new OA\Property(property: 'amount', description: 'Transaction amount', type: 'float', example: 350.56),
        new OA\Property(property: 'comment', description: 'Transaction comment', type: 'string', example: 'Transaction detail', nullable: true),
    ],
    example: [
        "from_user_id" => 1,
        "to_user_id"   => 2,
        "amount"       => 350.56,
        "comment"      => 'Transaction detail',
    ]
)]
class TransferRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @psalm-return array<string, ValidationRule|array|string>
     */
    public function rules() : array
    {
        return [
            'from_user_id' => 'required|integer',
            'to_user_id'   => 'required|integer',
            'amount'       => 'required|numeric|min:0',
            'comment'      => 'nullable|string',
        ];
    }
}
