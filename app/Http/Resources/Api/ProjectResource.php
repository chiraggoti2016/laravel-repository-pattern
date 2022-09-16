<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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
            'name'          =>  $this->name,
            'slug'          =>  $this->slug,
            'folder'        =>  $this->folder,
            'startdate'     =>  $this->startdate,
            'enddate'       =>  $this->enddate,
            'status'        =>  $this->status,
            'scope'         =>  $this->scope,
            'isNew'         =>  false,
            'participants'  =>  $this->participants ?? [],
            'questionaire'  =>  $this->questionaire,
        ];
    }
}
