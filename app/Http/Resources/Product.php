<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Product extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return[
            'id' => $this->id,
            'name' => $this->name,
            'brand' => $this->brand,
            'description' => $this->description,
            'section' => $this->section,
            'sub_section' => $this->sub_section,
            'category' => $this->category,
            // Map over collection
            'trends' => $this->trends->map(function($item, $key){
                // Return trend name
                return $item->name;
            }),
            'price' => $this->price,
            'color' => $this->color,
            'material' => $this->material,
            'images' => $this->images,
            'options' => $this->options,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at

        ];
    }
}
