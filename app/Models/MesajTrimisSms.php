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
        return "/mesje-trimise-sms/{$this->id}";
    }
}
