<?php

namespace App\Http\Resources\Order;

use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\User\UserResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'user_id' => $this->user_id,
            'total_price' => $this->total_price,
            'status' => $this->status->value,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'user' => new UserResource($this->whenLoaded('user')),

            'products' => ProductResource::collection($this->whenLoaded('products')),

            'order_products' => $this->products->map(function ($product) {
                return [
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'quantity' => $product->pivot->quantity,
                    'price_at_purchase' => $product->pivot->price_at_purchase,
                ];
            }),
        ];
    }
}
