<?php

namespace App\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * UserResource class for transforming user data into a JSON representation.
 *
 * This class defines the fields that can be included in the JSON output for a user.
 * It extends the JsonResource class and implements the availableFields method
 * to specify which fields are available for inclusion.
 *
 * @package App\Transformers
 */
class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'email'      => $this->email,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
