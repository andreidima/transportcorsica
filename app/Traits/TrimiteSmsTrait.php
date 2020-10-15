<?php

namespace App\Traits;
// use App\Student;

trait trimiteSmsTrait {
    public function trimiteSms($nr_telefon = null, $mesaj = null) 
    {
        dd($nr_telefon, $mesaj);
    }
}