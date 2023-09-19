<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'image' => env('AWS_S3_URL') . $this->image,
            'product_qty' => $this->product_qty,
            'products' => ProductResource::collection($this->whenLoaded('category')),
            'created_at' => $this->created_at
        ];
    }
}
