<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Klub extends Model
{
    use HasFactory;
    protected $fillable = ['nama_klub','logo','id_liga'];

    public function liga()
    {
        return $this->belogsTo(Liga::class, 'id_liga');
    }

    public function pemain()
    {
        return $this->hasMany(Pemain::class, 'id_klub');
    }

    public function fan()
    {
        return $this->belogsToMany(Fan::class, 'fan_klub', 'id_klub', 'id_fan');
    }
}
