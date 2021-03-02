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

    public function pasageri_relation()
    {
        return $this->belongsToMany('App\Models\Pasager', 'pasageri_rezervari', 'rezervare_id', 'pasager_id');
    }

    public function pasageri_relation_adulti()
    {
        return $this->pasageri_relation()->where('categorie', 'Adult');
    }

    public function pasageri_relation_copii()
    {
        return $this->pasageri_relation()->where('categorie', 'Copil');
    }

    public function factura()
    {
        return $this->hasOne('App\Models\Factura', 'rezervare_id');
    }

    public function factura_valida()
    {
        return $this->hasOne('App\Models\Factura', 'rezervare_id')->where('anulata', 0)->where('anulare_factura_id_originala', null);
    }

    public function plataOnlineUltima()
    {
        return $this->hasOne('App\Models\PlataOnline', 'rezervare_id')->latest();
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function retur_relation()
    {
        return $this->belongsTo('App\Models\Rezervare', 'retur');
    }
}
