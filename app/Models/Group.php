<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'status_complete'
    ];

    public function complete(){
        $this->status_complete = 'Completed';
        $this->save();
    }
}
