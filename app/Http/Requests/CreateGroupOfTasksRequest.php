<?php
namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class CreateGroupOfTasksRequest extends ApiRequest
{

    public function rules()
    {
        return [
            "tasks" => ["array"],
            "tasks.*.string" => ["required", "string"],
            "tasks.*.frequency" => ["required", "integer", "min:2"],
            "tasks.*.number_of_repetitions" => ["required", "integer", "min:2", "max:30"],
            "tasks.*.algorithm_name" => ["required", "string", Rule::in(['md5', 'sha1', 'sha256'])]
        ];
    }
}
