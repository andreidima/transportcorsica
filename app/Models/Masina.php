<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Masina extends Model
{
    use HasFactory;

    protected $table = 'masini';
    protected $guarded = [];

    public function path()
    {
        return "/masini/{$this->id}";
    }
}
