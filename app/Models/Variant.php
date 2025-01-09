<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    use HasFactory;
    protected $fillable = ['savol_id', 'name'];

    public function savol()
    {
        return $this->belongsTo(Savol::class);
    }

    public function ovozs()
    {
        return $this->hasMany(Ovoz::class);
    }
}

