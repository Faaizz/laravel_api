<?php

namespace App\Http\Resources;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Resources\Json\JsonResource;

class Staff extends JsonResource
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
            'api_token' => $this->api_token,
            'address' => $this->address,
            'gender' => $this->gender,
            'phone_numbers' => $this->phone_numbers,
            'privilege_level' => $this->when(Auth::guard('staffs')->user()->isAdmin(), $this->privilege_level),
            'created_at' => $this->when(Auth::guard('staffs')->user()->isAdmin(), $this->created_at),
            'updated_at' => $this->when(Auth::guard('staffs')->user()->isAdmin(), $this->updated_at),
         
            //Pending Orders
            'pending_orders' => \App\Order::where(
                                                [
                                                    'staff_email' => $this->email,
                                                    'status' => 'pending'
                                                ])->count()

        ];
    }
}
