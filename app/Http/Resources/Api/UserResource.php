<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'                =>  $this->id,
            'first_name'        =>  $this->first_name,
            'last_name'         =>  $this->last_name,
            'name'              =>  $this->name,
            'phone'             =>  $this->phone,
            'email'             =>  $this->email,
            'role'              =>  $this->role,
            'isNew'             =>  false,
            'email_verified_at' => $this->email_verified_at,
        ];
    }
}
