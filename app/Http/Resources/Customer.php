<?php

namespace App\Http\Resources;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Resources\Json\JsonResource;

class Customer extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'address' => $this->address,
            'gender' => $this->gender,
            'phone_numbers' => $this->phone_numbers,
            'activation_status' => $this->activation_status,
            'newsletters' => $this->newsletters,

            //pending orders
            'pending_orders' => \App\Order::where(
                                                    ['customer_email'=> $this->email,
                                                     'status' => 'pending'
                                                    ])->get()->count()
        ];
    }
}
