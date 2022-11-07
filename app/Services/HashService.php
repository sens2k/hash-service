<?php
namespace App\Services;

use App\Models\Task;

class HashService
{
    /* Генерация соли */
    public static function generateSalt($length = 10){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $salt = '';
        for ($i = 0; $i < $length; $i++) {
            $salt .= $characters[rand(0, $charactersLength - 1)];
        }
        return $salt;
    }

    /* Хеширование с переданными параметрами */
    public static function createHash(Task $hashTask){
        $hashTask->hash_string = hash($hashTask->algorithm_name, $hashTask->string);
        for($i = 0; $i < $hashTask->number_of_repetitions; $i++){
            $hashTask->hash_string = hash($hashTask->algorithm_name, $hashTask->hash_string.'_'.$hashTask->salt);
            usleep($hashTask->frequency * 1000);
        }
        $hashTask->setStatusComplete();
    }
}