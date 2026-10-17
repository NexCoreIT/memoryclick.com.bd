<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;

    public function scopeActive($q)
    {
        return $q->where('status', '1');
    }

    public function packages()
    {
        return $this->hasMany(Package::class);
    }
}
