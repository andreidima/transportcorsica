<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RezervareIstoric extends Model
{
    use HasFactory;

    protected $table = 'rezervari_istoric';
    protected $guarded = [];

    public function path()
    {
        return "/rezervari-istoric/{$this->id}";
    }
}
