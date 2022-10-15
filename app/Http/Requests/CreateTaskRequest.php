<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class CreateTaskRequest extends ApiRequest
{

    public function rules()
    {
        return [
            "string" => ["required", "string"],
            "frequency" => ["required", "integer"],
            "number_of_repetitions" => ["required", "integer", "min:2", "max:30"],
            "algorithm_name" => ["required", "string", Rule::in(['md5', 'sha1', 'sha256'])]
        ];
    }
}
