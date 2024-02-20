<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RezervareIstoric extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'rezervari_istoric';
    protected $guarded = [];

    public function path()
    {
        return "/rezervari-istoric/{$this->id}";
    }

    public function oras_plecare_nume()
    {
        return $this->belongsTo('App\Models\Oras', 'oras_plecare');
    }

    public function oras_sosire_nume()
    {
        return $this->belongsTo('App\Models\Oras', 'oras_sosire');
    }

    public function pasageri_relation()
    {
        return $this->belongsToMany('App\Models\PasagerIstoric', 'pasageri_rezervari_istoric', 'rezervare_id', 'pasager_id')->where('pasageri_istoric.operatie', 'Stergere');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'operatie_user_id');
    }
}
