<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MesajTrimisSms extends Model
{
    use HasFactory;

    protected $table = 'mesaje_trimise_sms';
    protected $guarded = [];

    public function path()
    {
        return "/mesaje-trimise-sms/{$this->id}";
    }

    public function rezervare()
    {
        return $this->belongsTo('App\Models\Rezervare', 'referinta_id');
    }
}
