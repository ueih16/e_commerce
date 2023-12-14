<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public static $wrap = false;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $customer   = $this->user->customer;
        $shipping   = $customer->shippingAddress;
        $billing    = $customer->billingAddress;

        return [
            'id'            => $this->id,
            'status'        => $this->status,
            'total_price'   => $this->total_price,
            'items'         => $this->orderItem->map(fn($orderItem) => [
                'id'            => $orderItem->id,
                'unit_price'    => $orderItem->unit_price,
                'quantity'      => $orderItem->quantity,
                'product'       => [
                    'id'    => $orderItem->product->id,
                    'slug'  => $orderItem->product->slug,
                    'title' => $orderItem->product->title,
                    'image' => $orderItem->product->image,
                ]
            ]),
            'customer' => [
                'id'                => $this->user->id,
                'email'             => $this->user->email,
                'first_name'        => $customer->first_name,
                'last_name'         => $customer->last_name,
                'phone'             => $customer->phone,
                'shippingAddress'   => [
                    'id'        => $shipping?->id,
                    'address1'  => $shipping?->address1,
                    'address2'  => $shipping?->address2,
                    'city'      => $shipping?->city,
                    'state'     => $shipping?->state,
                    'zipcode'   => $shipping?->zipcode,
                    'country'   => $shipping?->country->name,
                ],
                'billingAddress' => [
                    'id'        => $shipping?->id,
                    'address1'  => $shipping?->address1,
                    'address2'  => $shipping?->address2,
                    'city'      => $shipping?->city,
                    'state'     => $shipping?->state,
                    'zipcode'   => $shipping?->zipcode,
                    'country'   => $shipping?->country->name,
                ]
            ],
            'created_at' => (new \DateTime($this->created_at))->format('d-m-Y H:i:s'),
            'updated_at' => (new \DateTime($this->updated_at))->format('d-m-Y H:i:s'),
        ];
    }
}
