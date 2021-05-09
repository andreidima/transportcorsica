<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sofer extends Model
{
    use HasFactory;

    protected $table = 'soferi';
    protected $guarded = [];

    public function path()
    {
        return "/soferi/{$this->id}";
    }
}
