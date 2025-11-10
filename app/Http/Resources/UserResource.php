<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

/**
 * Class UserResource
 * @property-read User $resource
 */
class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request): array|Arrayable|JsonSerializable
    {
        return [
            'id'        => $this->resource->id,
            'name'      => $this->resource->name,
            'balance'   => $this->resource->balance,
            'createdAt' => $this->resource->created_at->format('d.m.Y H:i:s'),
            'updatedAt' => $this->resource->updated_at->format('d.m.Y H:i:s'),
        ];
    }
}
