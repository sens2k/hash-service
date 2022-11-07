<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'string', 'frequency',
        'number_of_repetitions',
        'algorithm_name',
        'status_completed',
        'hash_string',
        'group_id',
        'salt'
    ];

    public function group(){
        return $this->belongsTo('Group');
    }

    /* Метод изменения статуса выполнения */
    public function setStatusComplete($status = 'Completed'){
        $this->status_complete = $status;
        $this->save();
    }

}
