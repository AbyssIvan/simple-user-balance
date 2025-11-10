<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

#[OA\Schema(
    properties: [
        new OA\Property(property: 'name', description: 'User name', type: 'string', example: 'Some user name'),
    ],
    example: [
        "name" => 'Some user name',
    ]
)]
class UserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @psalm-return array<string, ValidationRule|array|string>
     */
    public function rules() : array
    {
        return [
            'name' => 'required|string',
        ];
    }
}
