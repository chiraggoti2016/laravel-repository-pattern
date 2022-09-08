<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
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
            'id'                    =>  $this->id,
            'question'              =>  $this->question	,
            'sub_question'          =>  $this->sub_question,
            'information'           =>  $this->information,
            'response_collector'    =>  $this->response_collector,
            'scope'                 =>  $this->scope,
            'category'              =>  $this->category,
        ];
    }
}
