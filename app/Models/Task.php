<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use function Symfony\Component\String\u;


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

    public function complete(){
        $this->status_complete = 'Completed';
        $this->save();
    }

    public function createHash()
    {
        $this->hash_string = hash($this->algorithm_name, $this->string);
        for($i = 0; $i < $this->number_of_repetitions; $i++){
            $this->hash_string = hash($this->algorithm_name, $this->hash_string.'_'.$this->salt);
            usleep($this->frequency * 1000);
        }
        $this->complete();
    }

    public static function generateSalt($length = 10){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $salt = '';
        for ($i = 0; $i < $length; $i++) {
            $salt .= $characters[rand(0, $charactersLength - 1)];
        }
        return $salt;
    }
}
