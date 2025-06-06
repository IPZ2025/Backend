<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdvertisementResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "description" => $this->description,
            "price" => $this->price,
            "created_at" => $this->created_at,
            "categories" => $this->categories->map(fn($item) => $item->name),
            "photos" => $this->photos->map(fn($item) => $item->url),
            "user_id" => $this->user->id,
        ];
    }
}
