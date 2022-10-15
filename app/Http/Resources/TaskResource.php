<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    public static $wrap = "task";

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'string' => $this->string,
            'algorithm' => $this->algorithm_name,
            'status' => $this->status_complete,
            'hash' => $this->hash_string
        ];
    }
}
