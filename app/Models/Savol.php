<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Savol extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'is_active'];

    public function variants()
    {
        return $this->hasMany(Variant::class);
    }

    public function ovozs()
    {
        return $this->hasMany(Ovoz::class);
    }
}

