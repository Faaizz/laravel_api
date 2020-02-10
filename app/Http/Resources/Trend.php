<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Trend extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'gender' => $this->gender,
            'products_number' => $this->products->count(),
            'images' => $this->images,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
