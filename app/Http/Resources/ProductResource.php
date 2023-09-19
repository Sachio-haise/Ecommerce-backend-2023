<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'description' => $this->description,
            'price' => $this->price,
            'image' => env('AWS_S3_URL') . $this->image,
            // 'gallery' => $this->getGallery($this->gallery),
            'gallery' => collect($this->gallery)->map(fn ($image) =>  env('AWS_S3_URL') . $image),
            'quantity' => $this->quantity,
            'discount' => $this->discount,
            'category_id' => $this->category_id,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'size' => $this->size,
            'created_at' => $this->created_at
        ];
    }

    protected function getGallery($gallery)
    {
        if (gettype($gallery) === 'array') {
            return [];
        } else {
            return collect(json_decode($this->gallery))->map(function ($image) {
                return env('AWS_S3_URL') . $image;
            });
        }
    }
}
