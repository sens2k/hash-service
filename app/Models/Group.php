<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'status_complete',
        'batch_group'
    ];

    public function tasks(){
        return $this->hasMany('Task');
    }

    /* Метод изменения статуса выполнения */
    public function execute(){
        $this->status_complete = 'Completed';
        $this->save();
    }

    /* Метод для установки id пакета задач */
    public function setBatchId($batchId){
        $this->batch_id = $batchId;
        $this->save();
    }
}
