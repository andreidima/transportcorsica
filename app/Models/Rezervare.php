<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rezervare extends Model
{
    use HasFactory;
    
    protected $table = 'rezervari';
    protected $guarded = [];

    public function path()
    {
        return "/rezervari/{$this->id}";
    }

    public function oras_plecare_nume()
    {
        return $this->belongsTo('App\Models\Oras', 'oras_plecare');
    }

    public function oras_sosire_nume()
    {
        return $this->belongsTo('App\Models\Oras', 'oras_sosire');
    }
}
