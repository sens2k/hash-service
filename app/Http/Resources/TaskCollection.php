<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TaskCollection extends ResourceCollection
{
    public static $wrap = "tasks";

    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
