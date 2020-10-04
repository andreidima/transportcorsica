<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasager extends Model
{
    use HasFactory;
    
    protected $table = 'pasageri';
    protected $guarded = [];

    public function path()
    {
        return "/pasageri/{$this->id}";
    }

    public function rezervari()
    {
        return $this->belongsToMany('App\Models\Rezervare', 'pasageri_rezervari', 'pasager_id', 'rezervare_id');
    }
}
