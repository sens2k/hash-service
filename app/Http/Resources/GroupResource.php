<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GroupResource extends JsonResource
{
    public static $wrap = "group";

    public function toArray($request)
    {
        return [
            'status_complete' => $this->status_complete,
        ];
    }
}
