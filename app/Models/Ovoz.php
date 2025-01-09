<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ovoz extends Model
{
    use HasFactory;
    protected $fillable = ['savol_id', 'user_ip', 'variant_id'];

    public function savol()
    {
        return $this->belongsTo(Savol::class);
    }

    public function variant()
    {
        return $this->belongsTo(Variant::class);
    }
}
