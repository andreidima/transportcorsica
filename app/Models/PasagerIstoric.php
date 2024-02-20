<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasagerIstoric extends Model
{
    use HasFactory;

    protected $table = 'pasageri_istoric';
    protected $guarded = [];

    public function path()
    {
        return "/pasageri-istoric/{$this->id}";
    }

    public function rezervari()
    {
        return $this->belongsToMany('App\Models\RezervareIstoric', 'pasageri_rezervari_istoric', 'pasager_id', 'rezervare_id');
    }
}
