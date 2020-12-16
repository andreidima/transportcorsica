<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlataOnline extends Model
{
    use HasFactory;
    
    protected $table = 'plata_online';
    protected $guarded = [];

    public function path()
    {
        return "/plata-online/{$this->id}";
    }

    public function rezervari()
    {
        return $this->belongsToMany('App\Models\Rezervare', 'rezervare_id');
    }
}
