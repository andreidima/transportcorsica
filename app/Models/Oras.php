<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Oras extends Model
{
    use HasFactory;

    protected $table = 'orase';
    protected $guarded = [];

    public function path()
    {
        return "/orase/{$this->id}";
    }
}
