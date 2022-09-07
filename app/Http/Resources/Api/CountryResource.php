<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource
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
            'id'            =>  $this->id,
            'sortname'      =>  $this->sortname,
            'country_name'  =>  $this->country_name,
            'country_lat'   =>  $this->country_lat,
            'country_lng'   =>  $this->country_lng,
            'timezone'      =>  $this->timezone,
        ];
    }
}
