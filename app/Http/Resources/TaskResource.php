<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    public static $wrap = false;

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'string' => $this->string,
            'algorithm' => $this->algorithm_name,
            'status' => $this->status_complete,
            'hash' => $this->hash_string,
            'group_id' => $this->when($this->group_id != null, function (){
                return $this->group_id;
            })
        ];
    }
}
