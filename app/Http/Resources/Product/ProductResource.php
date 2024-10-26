<?php

namespace App\Http\Resources\Product;

use App\Models\Category;
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
            'name' => $this->name,
            'description'=> $this->description,
            'price' => $this->price,
            'stock'=> $this->stock,
            'category_id' => $this->category_id,
            'category' => $this->whenLoaded(Category::class)
        ];
    }
}
